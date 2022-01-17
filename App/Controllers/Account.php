<?php

namespace App\Controllers;

use \App\Models\User;
use Evo\Controller;


/**
 * Account controller
 *
 */
class Account extends Controller
{

    /**
     * Validate if email is available (AJAX) for a new signup or an existing user.
     * The ID of an existing user can be passed in the query string to ignore when
     * checking if an email already exists or not.
     */
    public function validateEmailAction()
    {
        $is_valid = ! User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}
