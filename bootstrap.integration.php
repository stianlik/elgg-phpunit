<?php

global $START_MICROTIME;
$START_MICROTIME = microtime(true);

global $CONFIG;
$CONFIG = new \stdClass;
$CONFIG->boot_complete = false;

$settings = "engine/settings.php";

// Load configuration
if (stream_resolve_include_path('engine/settings.php')) {
    require_once 'engine/settings.php';
} else if (stream_resolve_include_path('engine/settings.example.php')) {
    require_once 'engine/settings.example.php';
}

// Load test configuration
if (stream_resolve_include_path('settings.phpunit.php')) {
    require_once 'integration/settings.phpunit.php';
}

// This will be overridden by the DB value but may be needed before the upgrade script can be run.
$CONFIG->default_limit = 10;

if (stream_resolve_include_path('engine/load.php')) {
    require_once 'engine/load.php';
} else {
    // Elgg 1.9 does not separate loading from bootstrap

    require_once("engine/lib/autoloader.php");
    require_once("engine/lib/elgglib.php");

    $lib_files = array(
	    'access.php',
	    'actions.php',
	    'admin.php',
	    'annotations.php',
	    'cache.php',
	    'comments.php',
	    'configuration.php',
	    'cron.php',
	    'database.php',
	    'entities.php',
	    'extender.php',
	    'filestore.php',
	    'friends.php',
	    'group.php',
	    'input.php',
	    'languages.php',
	    'mb_wrapper.php',
	    'memcache.php',
	    'metadata.php',
	    'metastrings.php',
	    'navigation.php',
	    'notification.php',
	    'objects.php',
	    'output.php',
	    'pagehandler.php',
	    'pageowner.php',
	    'pam.php',
	    'plugins.php',
	    'private_settings.php',
	    'relationships.php',
	    'river.php',
	    'sessions.php',
	    'sites.php',
	    'statistics.php',
	    'system_log.php',
	    'tags.php',
	    'user_settings.php',
	    'users.php',
	    'upgrade.php',
	    'views.php',
	    'widgets.php',
	    // backward compatibility
	    'deprecated-1.7.php',
	    'deprecated-1.8.php',
	    'deprecated-1.9.php',
    );

    foreach ($lib_files as $file) {
	    require_once("engine/lib/$file");
    }
}

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

if (stream_resolve_include_path('integration/bootstrap.php')) {
    require 'integration/bootstrap.php';
}
