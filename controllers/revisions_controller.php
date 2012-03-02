<?php
/**
 * Revisions Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Revisions
 * @version  1.0
 * @author   David Wu <david@marksweep.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
App::import('Controller', 'Nodes');

class RevisionsController extends NodesController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Revisions';
    
   	public $helpers = array('Revisions.Revisions', 'Tinymce.Tinymce');
   	
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
    public $uses = array('Setting', 'Revisions.Revision', 'Node');

    
    /**
     * admin_delete function.
     * Delete a given revision.
     * @param $id Id of the revision to delete
     */
    public function admin_delete($id) {
    
    	if (is_numeric($id)) {
    		// Is this the current revision? Do not allow deletes
    		$revision = $this->Revision->findById($id);
    		if ($revision) {
	    	
	    		// Cannot delete current active revision
	    		if ($revision['Revision']['is_current'] !== 1) {
		    		
		    		if ($this->Revision->delete($id)) {
		    			$this->Session->setFlash(__('Deleted revision'), true);
		    		} else {
		    			$this->Session->setFlash(__('Unable to delete revision'), true);
		    		}
		    	
		    	} else {
		    		$this->Session->setFlash(__('Cannot delete current revision'), true);
		    	}
			}    		
    	} else {
    		$this->Session->setFlash(__('Invalid revision id to delete', true));
	    }
	    
	    $this->redirect($this->referer());
    }
     
    /**
     * admin_edit function.
     * 
     * @access public
     * @param integer $id Id of the revision to edit
     * @return void
     */
    public function admin_edit($id) {
    	// Look up the revision id
    	if (!is_numeric($id)) {
    		$this->Session->setFlash(__('Invalid revision'));
    		$this->redirect($this->referer());
    	}
    	
    	if (!empty($this->data)) {
    		$this->data['Revision']['id'] = $id;
    		if (!$this->Revision->save($this->data)) {
    			$this->Session->setFlash(__('Unable to save revision'));
    		}
    		
    		$this->Session->setFlash(__('Saved changes to revision'));
    
    		$this->Revision->read(null, $id);
    		
    		$this->redirect(array('controller'=>'nodes', 'plugin'=>false, 'action'=>'admin_edit', $this->Revision->data['Revision']['node_id']));
    	
    	}
    	
    	$revision = $this->Revision->findById($id);
    	
    	$this->data = $revision;
    	
    	
    	
    }
    
    /**
     * admin_push function.
     * Takes the revision in question and pushes this to become the current 
     * node's revision, replacing existing node content.
     *
     * @access public
     * @param integer $id Id of the revision to make current revision of the node
     * @return void
     */
    public function admin_push($id) {
    
    	if (is_numeric($id)) {
    	
	    	// Grab the revision data
	    	$this->Revision->read(null, $id);
	    
	    	// Grab the node in question
	    	if (isset($this->Revision->data['Revision']['node_id'])) {
	    		$node = $this->Node->find('first', array(
	    			'conditions' => array(
	    				'Node.id' => $this->Revision->data['Revision']['node_id']
	    			)
	    		));
	    			    		
	    		// Save the node with the revisions data
	    		if (!$this->Revision->updateNodeData($node)) {
	    			debug('error');
	    		}
	    		
	    		// Make this revision the current
	    		if (!$this->Node->save($node)) {
	    		
					$this->Session->setFlash(__('Unable to push revision to current node - save failed', true));	
					$this->redirect($this->referer());
					
	    		}
	    			
	    		// Promote this to the current revision
	    		$this->Revision->makeCurrent();
	    		
    			$this->Session->setFlash(__('Pushed revision to current node', true));
    			$this->redirect($this->referer());
	    	}
	    	$this->Session->setFlash(__('Unable to push revision to current - invalid revision', true));
	    	$this->redirect($this->referer());
    	}
    	
    	$this->Session->setFlash(__('Unable to push revision to current - invalid  id', true));
    	$this->redirect($this->referer());
    }
    
    
    /**
     * view function.
     * Called by the <username>/<slug>/<revision> route to show a preview page of
     * a particular node and revision combination.
     *
     * @access public
     * @param mixed $id. Id of the node to view(default: null)
     * @return void
     */
    public function view($id = null) {
	    
	    if (isset($this->params['slug'])){
	    	$this->params['named']['slug'] = $this->params['slug'];
	    	$this->params['named']['revision'] = $this->params['revision'];
	    	$this->params['named']['type'] = $this->params['type'];
	    	
	    	// What node are we looking at?
	    	$nodeb = $this->Node->find('first', array(
	    		'conditions' => array(
	    			'Node.slug' => $this->params['slug']
	    		)
	    	));
	    	
	    	// Find the revision
	    	if ($nodeb) {
	    		$revision = $this->Revision->find('first', array(
	    		
	    			'conditions' => array(
	    				'Revision.node_id' => $nodeb['Node']['id'],
	    				'or' => array(
	    					'Revision.tag' => $this->params['revision'],
	    					'Revision.id' 	=> $this->params['revision']
	    				)
	    			)
	    		));
	    		
	    	}
    		$this->set('revision', $revision);
    		
	    }
    	
    	return parent::view($id);
    	
    }

}
?>