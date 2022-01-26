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

//use JetBrains\PhpStorm\Pure;
use Evo\FormBuilder\FormBuilderTypeInterface;
use Evo\FormBuilder\FormBuilderTrait;

class TextareaType implements FormBuilderTypeInterface
{

    use FormBuilderTrait;

    /** returns the name of the extension. IMPORTANT */
    protected string $type = 'textarea';
     /** returns the combined attr options from extensions and constructor fields */
    protected array $attr = [];
    /** return an array of form fields attributes */
    protected array $fields = [];
    /** returns an array of form settings */
    protected array $settings = [];
    
    protected $options = null;
    /** returns an array of default options set */
    protected array $baseOptions = [];

    public function __construct(array $fields, $options = null, array $settings = [])
    {
        $this->fields = $fields;
        $this->options = ($options !=null) ? $options : null;
        $this->settings = $settings;
        if (is_array($this->baseOptions)) {
            $this->baseOptions = $this->getBaseOptions();
        }
    }

    /**
     * Returns an array of base options.
     */
    public function getBaseOptions() : array
    {
        return [
            'name' => '',
            'id' => '',
            'class' => ['uk-textarea'],
            'placeholder' => '',
            'rows' => 5,
            'cols' => 33,
            'readonly' => false,
            'wrap' => '', /* wrap hard or soft */
            'maxlength' => '',
            'minlength' => '',
            'spellcheck' => false,
            'autocomplete' => 'off'
        ];
    }


    /**
     * Options which are defined for this object type
     * Pass the default array to the parent::configureOptions to merge together
     */
    public function configureOptions(array $options = []): void
    {
        $defaultWithExtensionOptions = (!empty($options) ? array_merge($this->baseOptions, $options) : $this->baseOptions);
        if ($this->fields) {
            $this->throwExceptionOnBadInvalidKeys(
                $this->fields, 
                $defaultWithExtensionOptions,
                __CLASS__
            );

            $this->attr = array_merge($defaultWithExtensionOptions, $this->fields);
        }
    }

    /**
     * Publicize the default object type to other classes
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Publicize the default object options to the base class
     */
    public function getOptions() : array
    {
        return $this->attr;
    }

    /**
     * Return the third argument from the add() method. This array can be used
     * to modify and filter the final output of the input and HTML wrapper
     */
    public function getSettings() : array
    {
        $defaults = [
            'container' => true,
            'show_label' => true,
            'new_label' => ''
        ];
        return (!empty($this->settings) ? array_merge($defaults, $this->settings) : $defaults);
    }

    /**
     * The prefilter method provides a way to filter the build field input
     * on a per object type basis as all types share the same basic tags
     *
     * there are cases where a tag is not required or valid within a
     * particular input/field. So we can filter it out here before being sent
     * back to the controller class
     */
    public function filtering(): string
    {
        return  $this->renderHtmlElement($this->attr);
    }

    /**
     * Render the form view to the builder method within the base class
     */
    public function view(): string
    { 
        return sprintf('<textarea %s>%s</textarea>', $this->filtering(), $this->options);
    }


}