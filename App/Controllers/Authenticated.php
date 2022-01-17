<?php

namespace App\Controllers;

use Evo\Controller;

abstract class Authenticated extends Controller
{
    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     */
    protected function before()
    {
        $this->requireLogin();
    }
}
