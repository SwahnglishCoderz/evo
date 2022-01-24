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

class isString extends ValidationRuleMethods
{

    public function isString(object $controller, object $validationClass)
    {
        if (isset($validationClass->key)) {
            if (!is_string($validationClass->value)) {
                $this->getError(array_values(Error::display('err_invalid_string'))[0], $controller, $validationClass);
            }
        }
    }
}
