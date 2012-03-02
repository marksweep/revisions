<?php
/**
 * Revisions Behavior
 *
 * PHP version 5
 *
 * @category Behavior
 * @package  Revisions
 * @version  1.0
 * @author   David Wu <david@marksweep.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/marksweep/revisions
 */
 
class RevisionsBehavior extends ModelBehavior {

	public $attach = false;
	
	/**
	 * Setup
	 *
	 * @param object $model
	 * @param array  $config
	 * @return void
	 */
    public function setup(&$model, $config = array()) {
        if (is_string($config)) {
            $config = array($config);
        }

        $this->settings[$model->alias] = $config;
    }
    
    public function beforeDelete(&$model){
    
    	if ($model->id) {
    	
    		// Delete all revisions with this node_id as well
 			$Revision = ClassRegistry::init('Revisions.Revision');
 			
 			$Revision->deleteAll(array(
 				'conditions' => array(
 					'Revision.node_id' => $model->id
 				)
 			));
    	
    	}
    	
    	return true;
    }
   
    
    /**
     * afterSave callback.
     * If the node is saved then create a copy in revisions.
     *
	 * @param object  $model
	 * @param array   $created
	 * @param boolean $primary
	 * @return array
 	 */
 	public function afterSave(&$model, $created) {
 
 		if (!empty($model->data)) {
 			
 			$Revision = ClassRegistry::init('Revisions.Revision');
 			// If the body, title, excerpt has been changed save a revision
 
 			$revision_id = $Revision->findMatchingRevision($model);
 			
 			if (!$revision_id) {	
	 		
	 			if ($Revision->saveRevision($model)) {
	 				// Since this is a new revision from the model data
	 				// We mark this as the current revision
	 		
	 				$Revision->makeCurrent();
	 			}
			} else {
				$Revision->id = $revision_id;
				$Revision->makeCurrent();
			}
			
 			// If a new revision is added, save this separately
 			if (
 				!empty($model->data['Revision']['title']) &&
 				!empty($model->data['Revision']['body'])
 			
 			) {
 			
 				// Check revision
 				$model->data['Revision']['node_id'] = $model->id;
 				$model->data['Revision']['user_id'] = $model->data['Revision']['current_user'];
 				$revision_id = $Revision->findMatchingRevision($model->data['Revision']);
 				
 				if (!$revision_id) {
 					
	 				$Revision->saveRevision($model->data['Revision']); 				
	 			}
 			}
 		}
 		
 		return true;
 	
 	}

	/**
	 * afterFind callback
	 *
	 * @param object  $model
	 * @param array   $created
	 * @param boolean $primary
	 * @return array
	 */
    public function afterFind(&$model, $results = array(), $primary = false) {
       //debug($model);
       //debug($primary);
       	if ($this->attach) {
	        // Find all revisions for this model as well if we're in the edit screen
	        // We should only have one node value
	        if (isset($results[0]['Node']['id'])) {
				$id = $results[0]['Node']['id'];
				
				// Find all revisions for this node
	 			$Revision = ClassRegistry::init('Revisions.Revision');
	 		
				$revisions = $Revision->find('all', array(
					'conditions' => array(
						'Revision.node_id' => $id
					), 
					'contain' => array(
						'User' => array('id', 'username')
					),
					'order' => array(
						'Revision.is_current' => 'desc',
						'Revision.created' => 'desc'
					)
				));
				
				$results[0]['Revisions'] = $revisions;
			
			}
			//debug($results);
		}
	    return $results;
    }

}
?>