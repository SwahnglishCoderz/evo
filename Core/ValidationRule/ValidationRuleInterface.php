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

interface ValidationRuleInterface
{
    public function addRule($rule): void;

    /**
     * Add additional object from the validation class which our validation rule methods
     * can use.
     */
    public function addObject(string $controller, object $validationClass): void;



}