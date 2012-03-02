<?php
/**
 * Submenu Behavior
 *
 * PHP version 5
 *
 * @category Behavior
 * @package  Submenu
 * @version  1.0
 * @author   David Wu <david@marksweep.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
 
class SubmenuBehavior extends ModelBehavior {
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
    

	/**
	 * afterFind callback
	 *
	 * @param object  $model
	 * @param array   $created
	 * @param boolean $primary
	 * @return array
	 */
    public function afterFind(&$model, $results = array(), $primary = false) {
       
       //debug($results);
       
        // Find all revisions for this model as well if we're in the edit screen
        // We should only have one node value
        if (isset($results[0]['Node']['id'])) {
			$id = $results[0]['Node']['id'];
			
			// Find all revisions for this node
 			$Revision = ClassRegistry::init('Submenu.Revision');
 		
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
			
			$results[0]['Submenu'] = $revisions;
		
		}
		//debug($results);
        return $results;
    }

}
?>