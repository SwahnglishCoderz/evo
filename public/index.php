<?php
/*
 * This file is part of the evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

/**
 * Load the composer autoloader library which enables us to bootstrap the application
 * and initialize the necessary components.
 */

require_once 'include.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Evo\Error::errorHandler');
set_exception_handler('Evo\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Evo\Router();

// Authentication routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' =>'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);

// Dashboard route
//$router->add('dashboard', ['controller' => 'Dashboard', 'action' => 'index']);

// General route pattern
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);