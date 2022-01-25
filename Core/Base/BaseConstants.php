<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Evo\Base;

final class BaseConstants
{

    /** Path the vendor src directory */
    private static string $vendorPath = 'Core/';
    /* Path the error handler resource files */
    private static string $errorResource = 'ErrorHandler/Resources/';

    /**
     * Defined common constants which are commonly used throughout the framework
     *
     * @return void
     */
    public static function load($app): void
    {
        
        defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        defined('APP_ROOT') or define('APP_ROOT', ROOT_PATH);
        defined('PUBLIC_PATH') or define('PUBLIC_PATH', 'public');
        defined('ASSET_PATH') or define('ASSET_PATH', '/' . PUBLIC_PATH . '/assets');
        defined('CSS_PATH') or define('CSS_PATH', ASSET_PATH . '/css');
        defined('JS_PATH') or define('JS_PATH', ASSET_PATH . '/js');
        defined('IMAGE_PATH') or define('IMAGE_PATH', ASSET_PATH . '/images');

        defined('TEMPLATE_PATH') or define('TEMPLATE_PATH', APP_ROOT . DS . 'App');
        defined('TEMPLATES') or define('TEMPLATES', $_SERVER['DOCUMENT_ROOT'] . 'App/Templates/');
        defined('STORAGE_PATH') or define('STORAGE_PATH', APP_ROOT . DS . 'Storage');
        defined('CACHE_PATH') or define('CACHE_PATH', STORAGE_PATH . DS);
        defined('LOG_PATH') or define('LOG_PATH', STORAGE_PATH . DS . 'logs');
        defined('ROOT_URI') or define('ROOT_URI', '');
        defined('RESOURCES') or define('RESOURCES', ROOT_URI);
        defined('UPLOAD_PATH') or define("UPLOAD_PATH", $_SERVER['DOCUMENT_ROOT'] . DS . "uploads/");

        defined('ERROR_RESOURCE') or define('ERROR_RESOURCE', $_SERVER['DOCUMENT_ROOT'] . self::$vendorPath . self::$errorResource);
        defined('TEMPLATE_ERROR') or define('TEMPLATE_ERROR', APP_ROOT . DS . self::$vendorPath . self::$errorResource);
        defined('EVO') or define('EVO', $_SERVER['DOCUMENT_ROOT'] . self::$vendorPath);

    }

    /**
     * Return the vendor directory source path
     *
     * @return string
     */
    public static function getVendorSrcDir(): string
    {
        return self::$vendorPath;
    }
}
