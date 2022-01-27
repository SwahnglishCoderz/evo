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

}
