<?php

declare(strict_types = 1);

namespace Evo\Utility;

class Validator
{

    /**
     * Undocumented function
     */
    public static function email(string $email)
    {
        if (!empty($email)) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
    }


}