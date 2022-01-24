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

    const ACTIVATION = [
        "title" => "Activate Your Account!",
        "message" => "Thanks for registering on 51mp1yG3n1u5. Please click the activation button below to activate your account in order to access your profile page.",
        "call_to_action" => "Activate Now"
    ];

    const APP = [
        "app" => [
            "app_name" => "51mp1yG3n1u5",
            "core_name" => "Evo",
            "app_version" => "1.0.0",
            "core_version" => "1.0.0",
            "app_email" => "simplygenius78@gmail.com",
            "app_author" => "John Andrew"
        ],
        "settings" => [
            "default_charset" => "UTF-8",
            "default_locale" => "en",
            "default_timezone" => "Africa/Nairobi",
            "favicon" => "",
            "apple_icon" => "",
            "secret_key" => "",
            "googleAnalytics" => "UA-XXXXX-Y"
        ],
        'logger_handler' => [
            "file" => "\\Evo\\Logger\\Handler\\NativeLoggerHandler",
            "array" => "\\Evo\\Logger\\Handler\\ArrayLoggerHandler",
            "database" => "\\Evo\\Logger\\Handler\\PdoLoggerHandler",
            "console" => "\\Evo\\Logger\\Handler\\ConsoleLoggerHandler",
            "echo" => "\\Evo\\Logger\\Handler\\EchoLoggerHandler"
        ]
    ];

    const ASSETS = [];

    const CACHE = [
        "cache_name" => "system_cache",
        "use_cache" => true,
        "storage" => "file",
        "key" => "auto",
        "cache_path" => "/Storage/cache/",
        "cache_expires" => 3600,
        "default_driver" => "native_storage",
        "drivers" => [
            "native_storage" => [
                "class" => "\\Evo\\Cache\\Storage\\NativeCacheStorage",
                "default" => true
            ],
            "array_storage" => [
                "class" => "\\Evo\\Cache\\Storage\\ArrayCacheStorage",
                "default" => false
            ],
            "pdo_storage" => [
                "class" => "\\Evo\\Cache\\Storage\\PdoCacheStorage",
                "default" => false
            ]
        ]
    ];

    const COMMANDS = [];

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

    const DEBUG_ERROR = [
        "mode" => "dev"
    ];

    const DISALLOWED_CONTROLLERS = [
        "home",
        "security",
        "password",
        "activation",
        "registration",
        "profile",
        "account",
        "install",
        "accessDenied",
        "admin",
        "event",
        "notification",
        "userRole",
        "logout"
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

    const ERROR_HANDLER = [
        "error" => "\\Evo\\ErrorHandler\\ErrorHandler => =>errorHandler",
        "exception" => "\\Evo\\ErrorHandler\\ErrorHandler => =>exceptionHandler",
        "log_path" => ""
    ];

    const LOCALE = [
        "en" => [
            "framework_name" => "Evo",
            "last_login" => "Last Login",
            "failed_logins" => "Failed Logins",
            "data_unavailable" => "Data Unavailable",
            "not_enough_data" => "Not Enough Data",
            "history" => "History",
            "recent_activity" => "Recent Activity",
            "notes" => "Notes",
            "firstname" => "Firstname",
            "lastname" => "Lastname",
            "email" => "Email",
            "status" => "Status",
            "created" => "Created",
            "account_still_pending" => "This account has been pending for more than 5 days",
            "resend_activation" => "Send reminder email!",
            "resend" => "Resend",
            "last_updated" => "Last Updated",
            "address_book" => "Address Book",
            "qualified_permission" => "Qualified Permissions",
            "permissions" => "Permissions",
            "permission_assigned" => "Permission Assigned",
            "assigned_to" => "Assigned To",
            "role" => "Role",
            "getting_started" => "Getting Started",
            "application" => "application",
            "whats_next" => "What's Next",
            "application_ready" => "Your application is now ready. You can start working on it.",
            "current_user" => "Current User",
            "server_information" => "Server Information",
            "login" => "Login",
            "sign_in" => "Sign In",
            "sign_out" => "Sign Out",
            "register" => "Register",
            "register_again" => "Register Again",
            "no_current_session" => "There are no current active session",
            "no_account" => "Don't have an account",
            "create_an_account" => "Create an Account",
            "already_register" => "Already register",
            "register_terms" => "By clicking Register, you accept our Terms of Use. Find out about our Privacy and Cookies Policy.",
            "forgotton_password" => "Forgotton your Password",
            "name" => "Name",
            "port" => "Port",
            "server_name" => "Server Name",
            "user_agent" => "User Agent",
            "server_software" => "Server Software",
            "script_name" => "Script Name",
            "php_version" => "PHP Version",
            "welcome" => "Welcome",
            "your_activated" => "You're Activated",
            "activation_failed" => "Activation Expired",
            "time_expired" => "Time Expired",
            "personal_details" => "Personal Details",
            "edit_name" => "Edit Name",
            "edit_email" => "Edit Email",
            "edit_password" => "Edit Password",
            "cancel" => "Cancel",
            "session_expired" => "Session Expired",
            "dashboard" => "Dashboard",
            "user_still_pending" => "users account still pending",
            "menu_items" => "Menu Items",
            "controller_name" => "Controller",
            "method_name" => "Method",
            "purge" => "Purge",
            "general" => "General",
            "backup" => "Backup",
            "update" => "Update",
            "tools" => "Tools",
            "active" => "Active",
            "account" => "Account",
            "member_since" => "Member Since",
            "delete_account" => "Delete this account",
            "hard_delete_excerpt" => "Please review account before deleting. As this action is not recoverable.",
            "gravatar" => "Gravatar",
            "password" => "Password",
            "activation_hash" => "Activation Hash",
            "last_5_users" => "Last 5 Users"
        ]
    ];

    const LOGGER_HANDLER = [
        "file" => "\\Evo\\Logger\\Handler\\NativeLoggerHandler",
        "array" => "\\Evo\\Logger\\Handler\\ArrayLoggerHandler",
        "database" => "\\Evo\\Logger\\Handler\\PdoLoggerHandler",
        "console" => "\\Evo\\Logger\\Handler\\ConsoleLoggerHandler",
        "echo" => "\\Evo\\Logger\\Handler\\EchoLoggerHandler"
    ];

    const PASSWORD_RECOVERY = [
        "title" => "Password Reset Requested",
        "message" => "You've requested to reset your password. Please click the link below to reset your password. However if you didn't make this request please click here. Password reset will expire in 30min.",
        "call_to_action" => "Reset Password!"
    ];

    const PROVIDERS = [
        "request" => "\\Evo\\Http\\RequestHandler",
        "response" => "\\Evo\\Http\\ResponseHandler",
        "restful" => "\\Evo\\RestFul\\RestHandler",
        "formBuilder" => "\\Evo\\FormBuilder\\FormBuilder",
        "eventDispatcher" => "\\Evo\\EventDispatcher\\EventDispatcher",
        "error" => "\\Evo\\Error\\Error",
        "tableGrid" => "\\Evo\\Datatable\\Datatable",
        "collection" => "\\Evo\\Collection\\Collection",
        "global" => "\\Evo\\Session\\GlobalManager\\GlobalManager",
        "flatDb" => "\\Evo\\Orm\\FileStorageRepository\\FileStorage",
        "FlatRepository" => "\\Evo\\Orm\\FileStorageRepository\\FileStorageRepository",
        "controllerSettings" => "\\Evo\\Settings\\Model\\ControllerSettingModel",
        "settings" => "\\Evo\\Settings\\Settings"
    ];

    const ROUTES = [];

    const SESSION = [
        "session_name" => "51mp1yG3n1u5",
        "idle_time" => 600,
        "lifetime" => 3600,
        "path" => "/",
        "domain" => "localhost",
        "secure" => false,
        "httponly" => true,
        "gc_maxlifetime" => "1800",
        "gc_probability" => "1000",
        "gc_divisor" => "1",
        "use_cookies" => "1",
        "globalized" => false,
        "default_driver" => "native_storage",
        "drivers" => [
            "native_storage" => [
                "class" => "\\Evo\\Session\\Storage\\NativeSessionStorage",
                "default" => true
            ],
            "array_storage" => [
                "class" => "\\Evo\\Session\\Storage\\ArraySessionStorage",
                "default" => false
            ],
            "pdo_storage" => [
                "class" => "\\Evo\\Session\\Storage\\PdoSessionStorage"
            ]
        ]
    ];

    const SETTINGS = [
        "default_charset" => "UTF-8",
        "default_locale" => "en",
        "default_timezone" => "Africa/Nairobi",
        "favicon" => "",
        "apple_icon" => "",
        "secret_key" => "",
        "googleAnalytics" => "UA-XXXXX-Y"
    ];

    const TEMPLATE = [
        "template_ext" => [
            ".html"
        ],
        "autoescaping" => false,
        "cache_reset" => 1800,
        "template_cache" => [
            "enable" => false,
            "path" => "cache/"
        ]
    ];

    const TOKEN_EXPIRED = [
        "title" => "Token Expired",
        "message" => "Its seem the requested token has expired. Possible reasons could be.",
        "reasons" => [
            "The token was already use to reset the password",
            "The token has pass the expiration time."
        ]
    ];

}
