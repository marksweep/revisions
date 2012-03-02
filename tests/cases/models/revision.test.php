<?php
App::import('Model', 'Revisions.Revision');
App::import('Model', 'Block');
App::import('Model', 'Region');
App::import('Model', 'Link');
App::import('Model', 'Node');
App::import('Model', 'Taxonomy');
App::import('Model', 'Vocabulary');

class RevisionTestCase extends CakeTestCase {

    public $fixtures = array(
        'plugin.revisions.revisions',
        'node',
        'user',
        'role',
        'block',
        'region',
        'link',
        'menu',
        'taxonomy',
        'nodes_taxonomy',
        'vocabulary'
    );

    public function startTest() {
         $this->Revision =& ClassRegistry::init('Revision');
         $this->Block =& ClassRegistry::init('Block');
         $this->Block =& ClassRegistry::init('Link');
         $this->Node =& ClassRegistry::init('Node');
    }
    
    public function testSaveRevision() {
    
    	// Save invalid nodes
    	//$this->assertFalse($this->Revision->saveRevision(null));
    	//$this->assertFalse($this->Revision->saveRevision(new Node()));
    	//$this->assertFalse($this->Revision->saveRevision('test'));
    
    
	}

    public function endTest() {
        unset($this->Revision);
        ClassRegistry::flush();
    }
}
?>