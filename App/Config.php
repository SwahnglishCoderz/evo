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

namespace App;

class Config
{

    const DB_HOST = '127.0.0.1';

    const DB_NAME = 'evo';

    const DB_USER = 'root';

    const DB_PASSWORD = '';

    const SHOW_ERRORS = true;

    const HASHING_SECRET_KEY = 'your-secret-key';

    const SMTP_USERNAME = 'b0645580e6fb52';

    const SMTP_PASSWORD = '9f4cd831c2ee3e';

    const SMTP_HOST = 'smtp.mailtrap.io';

    const SMTP_PORT = 2525;

    const SMTP_SECURE = 'tls';

    const SMTP_AUTH = true;

    const DATABASE = [
        "default_driver" => "mysql",
        "drivers" => [
            "mysql" => [
                "class" => "\\Evo\\Orm\\Drivers\\MysqlDatabaseConnection"
            ],
            "pgsql" => [
                "class" => "\\Evo\\Orm\\Drivers\\PgsqlDatabaseConnection"
            ],
            "sqlite" => [
                "class" => "\\Evo\\Orm\\Drivers\\SqliteDatabaseConnection"
            ]
        ]
    ];

    const ERROR = [
        "err_unchange" => "No changes",
        "err_account_not_active" => "Your account was found. But is not activated.",
        "err_field_require" => "One or more empty fields detected.",
        "err_password_require" => "Please enter your password.",
        "err_invalid_credentials" => "Unmatched credentials. Please try again.",
        "err_invalid_user" => "Invalid user credentials.",
        "error_password_length" => "Please enter at least 6 characters for the password",
        "err_password_letter" => "Password needs at least one letter.",
        "err_password_number" => "Password needs at least one number.",
        "err_mismatched_password" => "Your password does not match.",
        "err_invalid_email" => "Please enter a valid email address",
        "err_invalid_account" => "User account does not exists.",
        "err_unsupport_driver" => "Unsupported database driver selected.",
        "err_empty_host" => "Server host name can not be left empty.",
        "err_invalid_dbprefix" => "<strong>Table Prefix</strong> can only contain numbers, letters and underscore.",
        "err_empty_dbprefix" => "<strong>Table Prefix</strong> must not be empty.",
        "err_data_exists" => "already exists within the database",
        "err_invalid_csrf" => "Csrf validation failed. Please reload your page.",
        "err_invalid_url" => "Please enter a valid URL'",
        "err_invalid_array" => "Your value needs to be an array.",
        "err_invalid_string" => "Your value needs to be a string.",
        "err_invalid_int" => "Your value needs to be an integer.",
        "err_invalid_numeric" => "Your value needs to be an numeric value.",
        "err_password_force" => "You've entered your password incorrectly too many times. Please wait 30 seconds"
    ];

}
