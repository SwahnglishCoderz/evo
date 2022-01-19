<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

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
        $is_valid = ! User::doesEmailExist($_GET['email'], $_GET['ignore_id'] ?? null);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}
