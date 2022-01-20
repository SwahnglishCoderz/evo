<?php

namespace App\Controllers;

use Evo\View;

class Dashboard extends Authenticated
{
    public function index()
    {
        View::renderTemplate('dashboard/index.html');
    }

    public function new()
    {
        echo "new action";
    }

    public function show()
    {
        echo "show action";
    }
}