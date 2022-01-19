<?php

namespace App\Controllers;

use Evo\View;

class Dashboard extends Authenticated
{
    public function indexAction()
    {
        View::renderTemplate('Dashboard/index.html');
    }

    public function newAction()
    {
        echo "new action";
    }

    public function showAction()
    {
        echo "show action";
    }
}