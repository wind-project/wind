#!/usr/bin/env php
<?php 

if (!php_sapi_name() == 'cli')
	die('This is a command line only script.');

require_once dirname(__FILE__) . "/../globals/functions.php";
require_once dirname(__FILE__) . "/../globals/classes/DBUpdater.class.php";

// Load configuration
require dirname(__FILE__) . "/../config/config.php";

try {
	// Start-up updater
	$updater = new DBUpdater(
		$config['db']['server'],
		$config['db']['username'],
		$config['db']['password'],
		$config['db']['database']);
	
	$updates = require dirname(__FILE__) . "/updates/all.inc.php";
	$updater->updateTo(new SchemaVersion(1, 1), $updates);
} catch (Exception $e){
	die($e->getMessage() . "\n");
} 