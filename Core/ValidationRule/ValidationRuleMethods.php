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

namespace Evo\ValidationRule;

class ValidationRuleMethods
{

    protected array $errors = [];

    public function __construct()
    {
    }

    /**
     * Dispatch the validation error
     */
    public function getError(string $msg, object $controller, object $validationClass)
    {
        $controller->flashMessage($msg, $controller->flashWarning());
        $controller->redirect($controller->onSelf());

        // if (isset($controller->error)) {
        //     $controller
        //         ->error
        //         ->addError($this->errors, $controller)
        //         ->dispatchError(
        //             ($validationClass->validationRedirect() !== '') ? $validationClass->validationRedirect() :
        //                 $controller->onSelf()
        //         );

        // }
    }
}
