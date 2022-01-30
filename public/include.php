<?php
/*
 * This file is part of the evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// declare(strict_types = 1);

$vendorPath = '/Core/';


/**
 * Root constants required for the main index file
 */

defined('ROOT_PATH') or 
    define('ROOT_PATH', realpath(dirname(__FILE__, 2)));
defined('CONFIG_PATH') or 
    define("CONFIG_PATH", ROOT_PATH . '/' . "Config/");
defined('CORE_CONFIG_PATH') or 
    define("CORE_CONFIG_PATH", ROOT_PATH . $vendorPath . "System/Config/");
defined('LOG_PATH') or 
    define('LOG_PATH', ROOT_PATH . '/Storage/logs');
//echo ROOT_PATH;

/**
 * Load the composer library
 */
$autoload = ROOT_PATH . '/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
}