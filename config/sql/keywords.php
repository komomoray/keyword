<?php 
/* SVN FILE: $Id$ */
/* Keywords schema generated on: 2013-05-26 05:05:35 : 1369513595*/
class KeywordsSchema extends CakeSchema {
	var $name = 'Keywords';

	var $file = 'keywords.php';

	var $connection = 'plugin';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $keywords = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'pages_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'keywords' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'linked_smartphone' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'linked_mobile' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>