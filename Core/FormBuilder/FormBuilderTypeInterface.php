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

namespace Evo\FormBuilder;

use Evo\FormBuilder\Exception\FormBuilderInvalidArgumentException;
use Evo\FormBuilder\Exception\FormBuilderOutOfBoundsException;

interface FormBuilderTypeInterface
{
    /**
     * Options which are defined for this object type
     * Pass the default array to the parent::configureOptions to merge together
     */
    public function configureOptions(array $options = []) : void;

    /**
     * Publicize the default object type to other classes
     */
    public function getType() : string;

    /**
     * Publicize the default object options to the base class
     */
    public function getOptions() : array;

    /**
     * Return the third argument from the add() method. This array can be used
     * to modify and filter the final output of the input and HTML wrapper
     */
    public function getSettings() : array;

    /**
     * The prefilter method provides a way to filter the build field input
     * on a per object type basis as all types share the same basic tags
     *
     * there are cases where a tag is not required or valid within a
     * particular input/field. So we can filter it out here before being sent
     * back to the controller class
     */
    public function filtering(): string;

    /**
     * Render the form view to the builder method within the base class
     */
    public function view();

}