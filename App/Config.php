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

    const APP = [
        "app" => [
            "app_name" => "tajybb",
            "core_name" => "Nnaire",
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
        "theme_builder" => [
            "libraries" => [
                "uikit" => [
                    "class" => "\\Nnaire\\Themes\\Library\\Uikit\\Uikit",
                    "default" => true,
                    "version" => 1
                ],
                "bootstrap" => [
                    "class" => "\\Nnaire\\Themes\\Library\\Bootstrap\\Bootstrap",
                    "default" => false,
                    "version" => 1
                ],
                "tailwind" => [
                    "class" => "\\Nnaire\\Themes\\Library\\Tailwind",
                    "default" => false,
                    "version" => 1
                ]
            ]
        ],
        "session" => [
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
                    "class" => "\\Nnaire\\Session\\Storage\\NativeSessionStorage",
                    "default" => true
                ],
                "array_storage" => [
                    "class" => "\\Nnaire\\Session\\Storage\\ArraySessionStorage",
                    "default" => false
                ],
                "pdo_storage" => [
                    "class" => "\\Nnaire\\Session\\Storage\\PdoSessionStorage"
                ]
            ]
        ],
        "cache" => [
            "cache_name" => "system_cache",
            "use_cache" => true,
            "storage" => "file",
            "key" => "auto",
            "cache_path" => "/Storage/cache/",
            "cache_expires" => 3600,
            "default_driver" => "native_storage",
            "drivers" => [
                "native_storage" => [
                    "class" => "\\Nnaire\\Cache\\Storage\\NativeCacheStorage",
                    "default" => true
                ],
                "array_storage" => [
                    "class" => "\\Nnaire\\Cache\\Storage\\ArrayCacheStorage",
                    "default" => false
                ],
                "pdo_storage" => [
                    "class" => "\\Nnaire\\Cache\\Storage\\PdoCacheStorage",
                    "default" => false
                ]
            ]
        ],
        "system" => [
            "use_resolvable_action" => false,
            "use_session" => true,
            "use_cookie" => true,
            "logger" => [
                "use_logger" => true,
                "log" => [
                    "warnings",
                    "errors",
                    "critical",
                    "exceptions"
                ],
                "log_path" => "/Storage/Logs/"
            ],
            "use_translations" => true,
            "use_csrf" => true,
            "use_honeypot" => true,
            "use_hash_cost_factor" => 10,
            "use_auto_password" => "false,",
            "use_auth" => true,
            "activation_token_expiration" => 3600,
            "default_status" => "pending",
            "super_role" => [
                "props" => [
                    "name" => "Super",
                    "id" => 1,
                    "description" => "Roles which contains all priviledges"
                ]
            ],
            "default_role" => [
                "props" => [
                    "name" => "Subscriber",
                    "id" => 2,
                    "description" => "Role which allows basic user access"
                ]
            ]
        ],
        "gravatar" => [
            "rating" => "R",
            "size" => 200,
            "default" => "mystery"
        ],
        "security" => [
            "password_pattern" => "(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).[8,]",
            "url_pattern" => "https? =>//.+",
            "search_pattern" => "[^'\"]+",
            "email_pattern" => "[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z][2,]$",
            "tel_pattern" => "[0-9][3]-[0-9][3]-[0-9][4]",
            "random_pass_char" => 9,
            "login_timeout" => 30,
            "login_attempts" => 3,
            "hash_cost_factor" => [
                "cost" => 10
            ],
            "encript_password" => true,
            "password_algo" => [
                "default" => "PASSWORD_DEFAULT",
                "bcrypt" => "PASSWORD_BCRYPT",
                "argon2i" => "PASSWORD_ARGON2I",
                "argon2id" => "PASSWORD_ARGON2ID]"
            ]
        ],
        "database" => [
            "default_driver" => "mysql",
            "drivers" => [
                "mysql" => [
                    "class" => "\\Nnaire\\DataObjectLayer\\Drivers\\MysqlDatabaseConnection"
                ],
                "pgsql" => [
                    "class" => "\\Nnaire\\DataObjectLayer\\Drivers\\PgsqlDatabaseConnection"
                ],
                "sqlite" => [
                    "class" => "\\Nnaire\\DataObjectLayer\\Drivers\\SqliteDatabaseConnection"
                ]
            ]
        ],
        "debug_error" => [
            "mode" => "dev"
        ],
        "error_handler" => [
            "error" => "\\Nnaire\\ErrorHandler\\ErrorHandler => =>errorHandle",
            "exception" => "\\Nnaire\\ErrorHandler\\ErrorHandler => =>exceptionHandle",
            "log_path" => ""
        ],
        "logger_handler" => [
            "file" => "\\Nnaire\\Logger\\Handler\\NativeLoggerHandler",
            "array" => "\\Nnaire\\Logger\\Handler\\ArrayLoggerHandler",
            "database" => "\\Nnaire\\Logger\\Handler\\PdoLoggerHandler",
            "console" => "\\Nnaire\\Logger\\Handler\\ConsoleLoggerHandler",
            "echo" => "\\Nnaire\\Logger\\Handler\\EchoLoggerHandler"
        ],
        "disallowed_controllers" => [
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
        ],
        "activation" => [
            "title" => "Activate Your Account!",
            "message" => "Thanks for registering on LavaStudio. Please click the activation button below to activate your account in order to access your profile page.",
            "call_to_action" => "Activate Now"
        ],
        "password_recovery" => [
            "title" => "Password Reset Requested",
            "message" => "You've requested to reset your password. Please click the link below to reset your password. However if you didn't make this request please click here. Password reset will expire in 30min.",
            "call_to_action" => "Reset Password!"
        ],
        "token_expired" => [
            "title" => "Token Expired",
            "message" => "Its seem the requested token has expired. Possible reasons could be.",
            "reasons" => [
                "The token was already use to reset the password",
                "The token has pass the expiration time."
            ]
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

    const COMMANDS = [
        "make" => [
            "name" => "magma =>make",
            "class" => "\\Evo\\Console\\Commands\\MakeCommand",
            "help" => "help for making controller",
            "description" => "describe the make controller command",
            "argument" => [
                "stub",
                "name"
            ],
            "options" => [
                "crud",
                "-c"
            ],
            "stubs" => [
                "controller",
                "column",
                "entity",
                "fillable",
                "form",
                "model",
                "repository",
                "schema",
                "validate",
                "commander",
                "event",
                "event-listener",
                "event-subscriber",
                "before-middleware",
                "after-middleware",
                null
            ]
        ]
    ];

    const CONTROLLER = [
        "user" => [
            "status_choices" => [
                "active => Active",
                "pending => Pending",
                "lock => Lock",
                "trash => Trash"
            ],
            "additional_conditions" => [
                "status" => "active"
            ],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "status",
            "filter_by" => [
                "lastname"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "firstname",
                "created_at",
                "modified_at"
            ],
            "commander" => [
                "index" => [
                    "import" => [
                        "name" => "Import",
                        "icon" => "upload-outline",
                        "nav_header" => "WorkFlow",
                        "path" => ""
                    ],
                    "export" => [
                        "name" => "Export",
                        "icon" => "download-outline",
                        "path" => ""
                    ]
                ]
            ]
        ],
        "message" => [
            "status_choices" => [
                "inbox => Inbox",
                "draft => Draft",
                "sent => Sent",
                "trash => Trash"
            ],
            "additional_conditions" => [
                "status" => "inbox"
            ],
            "selectors" => [],
            "records_per_page" => 15,
            "query" => "status",
            "filter_by" => [
                "receiver"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "user_id",
                "created_at"
            ]
        ],
        "role" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "",
            "filter_by" => [
                "role_name"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "role_name",
                "created_at",
                "modified_at"
            ]
        ],
        "permission" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "",
            "filter_by" => [
                "permission_name"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "permission_name",
                "created_at",
                "modified_at"
            ]
        ],
        "setting" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "",
            "filter_by" => [
                "setting_name"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "setting_name"
            ]
        ],
        "plugin" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "",
            "filter_by" => [
                "plugin_name"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "plugin_name",
                "created_at",
                "modified_at",
                null
            ]
        ],
        "project" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "",
            "filter_by" => [
                "type",
                "status",
                "coordinator"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "type",
                "created_at",
                "modified_at",
                null
            ]
        ],
        "menu" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 5,
            "query" => "",
            "filter_by" => [
                "menu_name",
                "parent_menu"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "menu_name",
                "created_at",
                "modified_at",
                null
            ]
        ],
        "system" => [
            "status_choices" => [],
            "additional_conditions" => [],
            "selectors" => [],
            "records_per_page" => 10,
            "query" => "",
            "filter_by" => [
                "event_log_name"
            ],
            "filter_alias" => "s",
            "sort_columns" => [
                "event_type",
                "created_at"
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

    const EVENTS = [];

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

    const ROUTES = [
        "client_dir" => "client",
        "template_dir" => "Templates",
        "" => [
            "controller" => "home",
            "action" => "index"
        ],
        "login" => [
            "controller" => "security",
            "action" => "index"
        ],
        "logout" => [
            "controller" => "logout",
            "action" => "logout"
        ],
        "register" => [
            "controller" => "registration",
            "action" => "register"
        ],
        "password/reset/[token =>[\\da-f]+]" => [
            "controller" => "password",
            "action" => "reset"
        ],
        "activation/activate/[token =>[\\da-f]+]" => [
            "controller" => "activation",
            "action" => "activate"
        ],
        "profile/[controller]/[action]" => [
            "namespace" => "profile"
        ],
        "profile/[controller]/[id =>[\\da-f]+]/[action]" => [
            "namespace" => "profile"
        ],
        "admin/[controller]/[action]" => [
            "namespace" => "Admin"
        ],
        "admin/[controller]/[id =>[\\da-f]+]/[action]" => [
            "namespace" => "Admin"
        ],
        "api/[controller]/[action]" => [
            "namespace" => "API"
        ],
        "api/[controller]/[id =>[\\da-f]+]/[action]" => [
            "namespace" => "API"
        ],
        "installer/[controller]/[action]" => [
            "namespace" => "Installer",
            "controller" => "install",
            "action" => "index"
        ]
    ];

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

}
