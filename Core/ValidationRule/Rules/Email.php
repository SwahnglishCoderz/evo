<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Evo\ValidationRule\Rules;

use Evo\Error\Error;
use Evo\ValidationRule\ValidationRuleMethods;

class Email extends ValidationRuleMethods
{

    /**
     * Returns an error if the email field is invalid
     *
     * @param object $controller
     * @param object $validationClass
     * @return void
     */
    public function email(object $controller, object $validationClass): void
    {
        if (isset($validationClass->key)) {
            if (filter_var($validationClass->value, FILTER_VALIDATE_EMAIL) === false) {
                $this->getError(array_values(Error::display('err_invalid_email'))[0], $controller, $validationClass);
            }
        }
    }
}
