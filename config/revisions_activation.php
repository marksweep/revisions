<?php
/**
 * Revisions Activation
 *
 * Activation class for Revisions plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Revisions
 * @author   David Wu <david@marksweep.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/marksweep/revisions
 * @copyright IPRO 2012
 */
class RevisionsActivation {
/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
    public function beforeActivation(&$controller) {
        return true;
    }
/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
    public function onActivation(&$controller) {
        // ACL: set ACOs with permissions
        $controller->Croogo->addAco('Revisions'); // RevisionsController
        $controller->Croogo->addAco('Revisions/admin_index'); // RevisionsController::admin_index()
        $controller->Croogo->addAco('Revisions/view'); // RevisionsController::admin_index()
        $controller->Croogo->addAco('Revisions/index', array('registered', 'public')); // RevisionsController::index()

        // Main menu: add an Revisions link
        //$mainMenu = $controller->Link->Menu->findByAlias('main');
        //$controller->Link->Behaviors->attach('Tree', array(
        //    'scope' => array(
        //        'Link.menu_id' => $mainMenu['Menu']['id'],
        //    ),
        //));
        //$controller->Link->save(array(
        //    'menu_id' => $mainMenu['Menu']['id'],
        //    'title' => 'Revisions',
        //    'link' => 'plugin:Revisions/controller:Revisions/action:index',
        //    'status' => 1,
        //));
        
        // Attempt to add a revisions table to the database
        $sql = file_get_contents(APP.'plugins'.DS.'revisions'.DS.'config'.DS.'revisions.sql');
	        if(!empty($sql)){
	        	App::import('Core', 'File');
	        	App::import('Model', 'ConnectionManager');
	        	$db = ConnectionManager::getDataSource('default');

	        	$statements = explode(';', $sql);

		        foreach ($statements as $statement) {
		            if (trim($statement) != '') {
		                $db->query($statement);
		            }
		        }
	        }
		return true;
    }
/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
    public function beforeDeactivation(&$controller) {
        return true;
    }
/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
    public function onDeactivation(&$controller) {
        // ACL: remove ACOs with permissions
        $controller->Croogo->removeAco('Revisions'); // RevisionsController ACO and it's actions will be removed

        // Main menu: delete Revisions link
        //$link = $controller->Link->find('first', array(
        //    'conditions' => array(
        //         'Menu.alias' => 'main',
        //         'Link.link' => 'plugin:Revisions/controller:Revisions/action:index',
        //     ),
        // ));
        //$controller->Link->Behaviors->attach('Tree', array(
        //    'scope' => array(
        //        'Link.menu_id' => $link['Link']['menu_id'],
        //    ),
        //));
        //if (isset($link['Link']['id'])) {
        //    $controller->Link->delete($link['Link']['id']);
        //}
        
        // Remove the database files
        
        // Attempt to add a revisions table to the database
        $sql = file_get_contents(APP.'plugins'.DS.'revisions'.DS.'config'.DS.'revisions_deactivate.sql');
	        if(!empty($sql)){
	        	App::import('Core', 'File');
	        	App::import('Model', 'ConnectionManager');
	        	$db = ConnectionManager::getDataSource('default');

	        	$statements = explode(';', $sql);

		        foreach ($statements as $statement) {
		            if (trim($statement) != '') {
		                $db->query($statement);
		            }
		        }
	        }

    }
}
?>