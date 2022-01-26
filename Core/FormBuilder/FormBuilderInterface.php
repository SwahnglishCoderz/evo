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

interface FormBuilderInterface
{

    /**
     * Undocumented function
     */
    public function form(array $args = []) : self;

    /**
     * This method allows us to chain multiple input types together to build the required
     * form structure
     */
    public function add(array $args = [], $options = null, array $settings = []) : self;

    /**
     * This methods get chain at the very end after each add() method. And will attempt to build
     * the required input based on each add() method arguments. Theres an option to have
     * HTML elements wrap around each input tag for better styling of each element
     */
    public function build(array $args = []);

    /**
     * @return array
     */
    public function canHandleRequest() : array;

    /**
     * Check whether the form is submittable. Submit button should represent
     * the argument name
     */
    public function isSubmittable(string $name = 'submit') : bool;

    /**
     * Instantiate the external csrf fields
     */
    public function csrfForm($lock = null): string;

    /**
     * Wrapper function for validating csrf token
     */
    public function csrfValidate(): bool;

}