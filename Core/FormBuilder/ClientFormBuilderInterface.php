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

namespace Evo\FormBuilder;

interface ClientFormBuilderInterface
{
    /**
     * Build the form ready for the view render. One argument required
     * which is the action where the form will be posted
     */
    public function createForm(string $action, ?Object $dataRepository = null, ?object $callingController = null): string;

}