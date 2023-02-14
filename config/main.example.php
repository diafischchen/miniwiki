<?php

// Software Version
const VERSION = '1.1.3';

// App Name
const APP_NAME = 'Miniwiki';

// The URL pointing to the application
const ABSURL = 'http://localhost:2187/';

// Backend Paths
const APP_PATH = ABSPATH . '/app';
const CONFIG_PATH = ABSPATH . '/config';
const LIBS_PATH = ABSPATH . '/libs';
const VIEW_PATH = ABSPATH . '/view';
const WIKIS_PATH = ABSPATH . '/content/wikis';

// Debug
const DEBUG_MODE = false;

// Display Errors in Debug Mode
if (DEBUG_MODE) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Load additional config Files
require CONFIG_PATH . '/functions.php';
require CONFIG_PATH . '/auth.php';
require CONFIG_PATH . '/autoload.php';

// Load Libs
require LIBS_PATH . '/autoload.php';