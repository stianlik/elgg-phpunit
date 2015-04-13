<?php

global $START_MICROTIME;
$START_MICROTIME = microtime(true);

global $CONFIG;
$CONFIG = new \stdClass;
$CONFIG->boot_complete = false;

$settings = "engine/settings.php";

// Use sample config if Elgg is not yet configured
if (stream_resolve_include_path('engine/settings.php')) {
    $settings = "engine/settings.example.php";
}

// Load configuration
if (stream_resolve_include_path($settings)) {
    require_once $settings;
}

// Load test configuration
if (stream_resolve_include_path('settings.phpunit.php')) {
    require_once 'settings.phpunit.php';
}

// This will be overridden by the DB value but may be needed before the upgrade script can be run.
$CONFIG->default_limit = 10;

require_once 'engine/load.php';

// Connect to database, load language files, load configuration, init session
// Plugins can't use this event because they haven't been loaded yet.
elgg_trigger_event('boot', 'system');

// Load the plugins that are active
_elgg_load_plugins();

// @todo move loading plugins into a single boot function that replaces 'boot', 'system' event
// and then move this code in there.
// This validates the view type - first opportunity to do it is after plugins load.
$viewtype = elgg_get_viewtype();
if (!elgg_is_registered_viewtype($viewtype)) {
	elgg_set_viewtype('default');
}

// @todo deprecate as plugins can use 'init', 'system' event
elgg_trigger_event('plugins_boot', 'system');

// Complete the boot process for both engine and plugins
elgg_trigger_event('init', 'system');

$CONFIG->boot_complete = true;

// System loaded and ready
elgg_trigger_event('ready', 'system');
