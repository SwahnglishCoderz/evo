<?php

namespace App\Controllers;

use Core\Controller;
use \Core\View;
use \App\Auth;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends Controller
{

    /**
     * Show the index page
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.html');
    }
}
