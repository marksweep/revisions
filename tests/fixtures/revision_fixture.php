<?php
/* Revision Fixture  */
class RevisionFixture extends CakeTestFixture {
	var $name = 'Revision';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_current' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'tag' => array('type' => 'string', 'null' => false, 'default' => 'node', 'length' => 255),
		'title' => array('type' => 'string', 'null' => false, 'default' => 'node', 'length' => 255),
		'body' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'excerpt' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'md5' => array('type' => 'string', 'null' => false, 'default' => 'node', 'length' => 64),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'node_id' => 1,
			'user_id' => 1,
			'is_current' => 0,
			'tag' => 'OLD HEAD',
			'title' => 'Original Title',
			'body' => '<p>Original Body</p>',
			'excerpt' => 'Original Excerpt',
			'md5' => '79779617e12a8f48c557dd0d9fb3a57f',
			'created' => '2012-02-23 00:00:00'
		),
		array(
			'id' => 2,
			'node_id' => 1,
			'user_id' => 1,
			'is_current' => 1,
			'tag' => 'HEAD',
			'title' => 'Title',
			'body' => '<p>Body</p>',
			'excerpt' => 'Excerpt',
			'md5' => '1a9a5055bcf8b0ce9b41807c0f92c7da',
			'created' => '2012-02-23 00:00:00'
		),
	);
}
?>