<?php
/**
 * Revision
 *
 * PHP version 5
 *
 * @category Model
 * @package  Revisions
 * @version  1.0
 * @author   David Wu <david@marksweep.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/marksweep/revisions
 */
 
 /**
  * Revision Model.
  * Revisions are stored for nodes. Revisions allow you to create and preview 
  * changes to pages. All edits to the node are saved in revisions. Revision
  * can be promoted to replace the current node.
  */
class Revision extends RevisionsAppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User'
		)
	);
	
	/**
	 * saveRevision function.
	 * 
	 * @access public
	 * @param mixed $node Node object to be used for revision or array of data
	 * @return boolean Returns false if unsuccessful true otherwise
	 */
	public function saveRevision($node) {
	
		// Is this a node object? 
		if (is_object($node) && isset($node->data)) {
		
				if (isset($node->id)) {
					$node_id = $node->id;
				} else if (isset($node->data['Node']['id'])) {
					$node_id = $node->data['Node']['id'];
				} else {
					return false;
				}
				
				// Try to extract node data for our revision
	 			$data = array('Revision'=>array(
	 				'node_id' 	=> $node_id,
	 				'title' => $node->data['Node']['title'],
	 				'user_id' => (isset($node->data['Revision']['current_user']) ? $node->data['Revision']['current_user'] : $node->data['Node']['user_id']),
	 				'body' => $node->data['Node']['body'],
	 				'excerpt' => $node->data['Node']['excerpt'],
	 				'md5' => $this->hashData($node->data),
	 				'created' => date('Y-m-d H:i:s')
	 			));
		} else if (is_array($node)) {
		
			// Node array?
			if (isset($node['Node'])) {
				$data['Revision'] 			= $node['Node'];
				$data['Revision']['md5']	= $this->hashData($node);
			} else {
				$data = $node;
				$data['md5']		= $this->hashData($node);
			}
		
		
		} else {
			return false;
		}
		
		// Save a new revision
	 	$this->create();
		return $this->save($data);
	
	}
	
	/**
	 * makeCurrent function.
	 * 
	 * @access public
	 * @return void
	 */
	public function makeCurrent() {
		
		// The ->id should be set
		if (isset($this->id)) {
			
			// Not loaded? Load in this revision
			if (!isset($this->data['Revision']['node_id'])) {

				$this->read(null, $this->id);
			}
	
			// Remove the current flag for all others
			if (isset($this->data['Revision']['node_id'])) {
				$this->updateAll(
					array(
						'Revision.is_current' => 0
					),
					array (
						'Revision.node_id' => $this->data['Revision']['node_id']
					)
				);
			}	

			// Now set our revision to be the current revision
			$this->saveField('is_current', 1);
			
		} 
	}
	
	/**
	 * findMatchingRevision function.
	 * 
	 * @access public
	 * @param mixed $model
	 * @return void
	 */
	public function findMatchingRevision($model) {

		// Are we being passing in an object?
		if (is_object($model)) {
			if (!isset($model->id)){
				return false;
			}
			
			if (!isset($model->data) || $model->data == null) {
				$model->read(null, $model->id);
			}
			$data = $model->data;
			$data['id'] = (isset($model->data['id']) ? $model->data['id'] : $model->id);
		} else if (is_array($model) && isset($model['node_id'])){
			$data = $model;
		} else {
			return false;
		}
		
		// Compute the md5 for this model
		$md5 = $this->hashData($data);
		
		// Does this match any current revisions?
		$revision = $this->find('first', array(
			'conditions' => array(
				'Revision.node_id' => (isset($data['id']) ? $data['id'] : $data['node_id']),
				'Revision.md5' => $md5
			),
			'contain' => array(
				'Revision'
			)
		));
		
		if (isset($revision['Revision']['id'])) {
			return $revision['Revision']['id'];
		} else {
			return false;
		}	
	}
	
	
	/**
	 * updateNodeData function.
	 * Takes the current revision information and updates the node variable
	 * with the node information.
	 *
	 * @access public
	 * @param mixed &$node Accepts either a node object or an array
	 * @return boolean Returns false if unsuccessful
	 */
	public function updateNodeData(&$node) {
	
		// Expects the revision id to be set
		if (isset($this->id)) {
			// Not loaded? Load in this revision
			if (isset($this->data['Revision'])) {
				$this->read(null, $this->id);
			}
		} else {
			return false;
		}
	
		if (is_object($node)) {
			$node->data['Node']['title'] = $this->data['Revision']['title'];
			$node->data['Node']['excerpt'] = $this->data['Revision']['excerpt'];
			$node->data['Node']['body'] = $this->data['Revision']['body'];
		} else if (is_array($node)) {

			if (isset($node['Node'])) {
			
				$node['Node']['title'] = $this->data['Revision']['title'];
				$node['Node']['excerpt'] = $this->data['Revision']['excerpt'];
				$node['Node']['body'] = $this->data['Revision']['body'];
				
			} else {
				$node['title'] = $this->data['Revision']['title'];
				$node['excerpt'] = $this->data['Revision']['excerpt'];
				$node['body'] = $this->data['Revision']['body'];
			}
		} else {
			return false;
		}
	
		return true;
	}
	
	/**
	 * hashData function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return void
	 */
	public function hashData($data) {
		if (isset($data['Node'])){
			$data = $data['Node'];
		} else if (isset($data['Revision'])) {
			$data = $data['Revision'];
		}
		
		$md5 = md5(
			(isset($data['title']) ? $data['title'] : '') . 
			(isset($data['body']) ? $data['body'] : '') . 
			(isset($data['excerpt']) ? $data['excerpt'] : ''));

		return $md5;
	}


}