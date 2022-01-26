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

class DateType extends InputType implements FormExtensionTypeInterface
{
    protected string $type = 'date';
    protected array $defaults = [];

    public function __construct(array $fields, $options = null, array $settings = [])
    {
        parent::__construct($fields, $options, $settings);
    }

    public function configureOptions(array $extensionOptions = []): void
    {
        $this->defaults = [
            'min' => '10',
            'max' => '100',
            'step' => ''
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