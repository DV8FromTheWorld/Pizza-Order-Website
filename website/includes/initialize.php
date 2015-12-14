<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('RET_SITE_ROOT') ? null : define('RET_SITE_ROOT', DS.'usr'.DS.'local'.DS.'apache2'.DS.'htdocs'.DS.'cs'.DS.'ret');

defined('RET_LIB_PATH') ? null : define('RET_LIB_PATH', RET_SITE_ROOT.DS.'includes');

// load config file first
require_once(RET_LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(RET_LIB_PATH.DS.'functions.php');

// load core objects
require_once(RET_LIB_PATH.DS.'database.php');

// load database-related classes
require_once(RET_LIB_PATH.DS.'person.php');
require_once(RET_LIB_PATH.DS.'applicant.php');
require_once(RET_LIB_PATH.DS.'reference.php');
require_once(RET_LIB_PATH.DS.'supervisor.php');