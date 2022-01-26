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

namespace Evo\FormBuilder\Type;

use Evo\FormBuilder\FormExtensionTypeInterface;
use Evo\Utility\Yaml;

class EmailType extends InputType implements FormExtensionTypeInterface
{
    protected string $type = 'email';
    protected array $defaults = [];

    public function __construct(array $fields, $options = null, array $settings = [])
    {
        parent::__construct($fields, $options, $settings);
    }

    public function configureOptions(array $extensionOptions = []): void
    {
        $this->defaults = [
            /**
             * An <input> element with type="email" that must be in the following 
             * order: characters@characters.domain (characters followed by an @ sign, 
             * followed by more characters, and then a "."
             * After the "." sign, add at least 2 letters from a to z:
             */
            'pattern' => Yaml::file('app')['security']['email_pattern'],
            'list' => '',
            'maxlength' => '',
            'minlength' => '',
            'multiple' => false, /* whether to allow multiple email separated by comma (,) */
            'placeholder' => '',
            'readonly' => false,
            'size' => '',
            'value' => ''
        ];

        parent::configureOptions($this->defaults);
    }

    public function getExtensionDefaults() : array
    {
        return $this->defaults;
    }

    /**
     * Publicize the default object options to the base class
     */
    public function getOptions() : array
    {
        return parent::getOptions();
    }

    /**
     * Return the third argument from the add() method. This array can be used
     * to modify and filter the final output of the input and HTML wrapper
     */
    public function getSettings() : array
    {
        return parent::getSettings();
    }


}