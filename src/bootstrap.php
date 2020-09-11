<?php
const CI_VERSION = '3.1.11';
$root_path = dirname(dirname(dirname(dirname(__DIR__)))); // Мега костыль!
$system_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR;

define('ENVIRONMENT', 'development');
// Path to the system directory
define('BASEPATH', $system_path);

// Path to the front controller (this file) directory
define('FCPATH', $root_path . DIRECTORY_SEPARATOR . 'public');

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

define('APPPATH', $root_path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'CI' . DIRECTORY_SEPARATOR );

define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);


/*
 * ------------------------------------------------------
 *  Load the framework constants
 * ------------------------------------------------------
 */
if (file_exists(APPPATH . 'config/constants.php')) {
    require_once(APPPATH . 'config/constants.php');
}

/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require_once(BASEPATH . 'core/Common.php');


/*
 * ------------------------------------------------------
 *  Instantiate the config class
 * ------------------------------------------------------
 *
 * Note: It is important that Config is loaded first as
 * most other classes depend on it either directly or by
 * depending on another class that uses it.
 *
 */
$CFG =& load_class('Config', 'core');

if (extension_loaded('mbstring')) {
    define('MB_ENABLED', true);
    // This is required for mb_convert_encoding() to strip invalid characters.
    // That's utilized by CI_Utf8, but it's also done for consistency with iconv.
    mb_substitute_character('none');
} else {
    define('MB_ENABLED', false);
}

// There's an ICONV_IMPL constant, but the PHP manual says that using
// iconv's predefined constants is "strongly discouraged".
if (extension_loaded('iconv')) {
    define('ICONV_ENABLED', true);
} else {
    define('ICONV_ENABLED', false);
}

/*
 * ------------------------------------------------------
 *  Load compatibility features
 * ------------------------------------------------------
 */

require_once(BASEPATH . 'core/compat/mbstring.php');
require_once(BASEPATH . 'core/compat/hash.php');
require_once(BASEPATH . 'core/compat/password.php');
require_once(BASEPATH . 'core/compat/standard.php');

/*
 * ------------------------------------------------------
 *  Instantiate the UTF-8 class
 * ------------------------------------------------------
 */
$UNI =& load_class('Utf8', 'core');

/*
 * ------------------------------------------------------
 *  Instantiate the URI class
 * ------------------------------------------------------
 */
if(!is_cli()) {
    $URI =& load_class('URI', 'core');
}

/*
 * ------------------------------------------------------
 *  Instantiate the output class
 * ------------------------------------------------------
 */
$OUT =& load_class('Output', 'core');

/*
 * -----------------------------------------------------
 * Load the security class for xss and csrf support
 * -----------------------------------------------------
 */
$SEC =& load_class('Security', 'core');

/*
 * ------------------------------------------------------
 *  Load the Input class and sanitize globals
 * ------------------------------------------------------
 */
$IN =& load_class('Input', 'core');

/*
 * ------------------------------------------------------
 *  Load the Language class
 * ------------------------------------------------------
 */
$LANG =& load_class('Lang', 'core');

/*
 * ------------------------------------------------------
 *  Load the app controller and local controller
 * ------------------------------------------------------
 *
 */
// Load the base controller class
require_once BASEPATH . 'core/Controller.php';


/**
 * Reference to the CI_Controller method.
 *
 * Returns current CI instance object
 *
 * @return object
 */
function &get_instance()
{
    return CI_Controller::get_instance();
}

if (file_exists(APPPATH . 'core/' . $CFG->config['subclass_prefix'] . 'Controller.php')) {
    require_once APPPATH . 'core/' . $CFG->config['subclass_prefix'] . 'Controller.php';
}
