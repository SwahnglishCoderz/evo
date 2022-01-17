<?php

namespace App\Controllers;

use Evo\Controller;
use Evo\View;
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
