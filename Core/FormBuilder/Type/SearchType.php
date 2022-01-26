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

class SearchType extends InputType implements FormExtensionTypeInterface
{
    protected string $type = 'search';
    protected array $defaults = [];

    public function __construct(array $fields, $options = null, array $settings = [])
    {
        parent::__construct($fields, $options, $settings);
    }

    public function configureOptions(array $extensionOptions = []): void
    {
        $this->defaults = [
            /**
             * An <input> element with type="search" that CANNOT contain the 
             * following characters: ' or " 
             */
            'list' => '',
            'pattern' => Yaml::file('app')['security']['search_pattern'],
            'maxlength' => '',
            'minlength' => '',
            'placeholder' => '',
            'readonly' => false,
            'size' => '',
            'spellcheck' => '',
            'title' => 'Invalid input'
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