<?php

/**
 * Install Elgg and activate plugin
 */

// Prepare environment
$_SERVER['SERVER_PORT'] = 443;
set_include_path('.:../../:./tests:' . get_include_path());

// Autoloader
require_once 'engine/load.php';

// Configuration
global $CONFIG;
$CONFIG = new stdClass();
$CONFIG->site_guid = 0;
$CONFIG->i18n_loaded_from_cache = false;
$CONFIG->dbuser = '';
$CONFIG->dbpass = '';
$CONFIG->dbname = '';
require_once 'settings.phpunit.php';

// Install Elgg
$installer = new ElggInstaller();
$installer->batchInstall(array(
	// database parameters
	'dbuser' => $CONFIG->dbuser,
	'dbpassword' => $CONFIG->dbpass,
	'dbname' => $CONFIG->dbname,

	// site settings
	'sitename' => 'Test site',
	'siteemail' => 'test@test.com',
	'wwwroot' => 'http://localhost/',
	'dataroot' => 'data/',
	'path' => '',

	// admin account
	'displayname' => 'Administrator',
	'email' => 'administrator@test.com',
	'username' => 'administrator',
	'password' => 'administrator',
));

// Activate plugin
elgg_set_ignore_access(true);
$path = _elgg_services()->config->getPluginsPath() . basename(getcwd());
$plugin = new ElggPlugin($path);
$plugin->save();
$plugin->activate();

echo "Elgg installed\n";
