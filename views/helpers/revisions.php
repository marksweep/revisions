<?php
/**
 * Revisions Helper
 *
 * An Revisions hook helper for demonstrating hook system.
 *
 * @category Helper
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class RevisionsHelper extends AppHelper {
/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    public $helpers = array(
        'Html',
        'Layout',
    );
    
    public function __construct($settings = array()) {
    	$this->viewVars = ClassRegistry::getObject('view')->viewVars;
    }
/**
 * Before render callback. Called before the view file is rendered.
 *
 * @return void
 */
    public function beforeRender() {
    }
/**
 * After render callback. Called after the view file is rendered
 * but before the layout has been rendered.
 *
 * @return void
 */
    public function afterRender() {
    }
/**
 * Before layout callback. Called before the layout is rendered.
 *
 * @return void
 */
    public function beforeLayout() {
    }
/**
 * After layout callback. Called after the layout has rendered.
 *
 * @return void
 */
    public function afterLayout() {
    }
/**
 * Called after LayoutHelper::setNode()
 *
 * @return void
 */
    public function afterSetNode() {
        // field values can be changed from hooks
    }
/**
 * Called before LayoutHelper::nodeInfo()
 *
 * @return string
 */
    public function beforeNodeInfo() {
    	if (isset($this->viewVars['revision'])) {
    		return '<div class="originalnodeinfo original" style="display:none">';
    	}
    }
/**
 * Called after LayoutHelper::nodeInfo()
 *
 * @return string
 */
    public function afterNodeInfo() {
    	
    	if (isset($this->viewVars['revision'])) {
    		$body = '</div>';
    	
    		$body .= '<div class="revision revisionnodebody">' . $this->viewVars['revision']['Revision']['body'] . '</div>';
    	
    		return $body;
    	}
    	
    	
    }
/**
 * Called before LayoutHelper::nodeBody()
 *
 * @return string
 */
    public function beforeNodeBody() {
    	if (isset($this->viewVars['revision'])) {
    		return '<div class="originalnode original">';
    	}
    }
/**
 * Called after LayoutHelper::nodeBody()
 *
 * @return string
 */
    public function afterNodeBody() {
    	if (isset($this->viewVars['revision'])) {
    		 '</div>';
    	}
    }
/**
 * Called before LayoutHelper::nodeMoreInfo()
 *
 * @return string
 */
    public function beforeNodeMoreInfo() {
    	if (isset($this->viewVars['revision'])) {
    		return '<div class="originalmoreinfo original">';
    	}
    }
/**
 * Called after LayoutHelper::nodeMoreInfo()
 *
 * @return string
 */
    public function afterNodeMoreInfo() {
    
    	if (isset($this->viewVars['revision'])) {
    		return '</div>';
    	}
    }
}
?>