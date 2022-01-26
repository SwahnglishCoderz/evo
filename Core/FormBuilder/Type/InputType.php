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

use Evo\Utility\Stringify;
use Evo\FormBuilder\FormBuilderTrait;
use Evo\FormBuilder\FormBuilderTypeInterface;
use Evo\FormBuilder\FormExtensionTypeInterface;
use Evo\FormBuilder\Exception\FormBuilderInvalidArgumentException;


class InputType implements FormBuilderTypeInterface
{

    use FormBuilderTrait;

    /** returns the name of the extension. IMPORTANT */
    protected string $type = '';
     /** returns the combined attr options from extensions and constructor fields */
    protected array $attr = [];
    /** return an array of form fields attributes */
    protected $fields;
    /** returns an array of form settings */
    protected array $settings = [];
    
    protected $options = null;
    /** returns an array of default options set */
    protected array $baseOptions = [];

    public function __construct(array $fields, $options = null, array $settings = [])
    {
        $this->fields = $this->filterArray($fields);
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
            'type' => $this->type, 
            'name' => '', 
            'id' => ($this->fields['name'] ?? ''),
            'class' => ['uk-input'],
            'checked' => false, 
            'required' => false, 
            'disabled' => false, 
            'autofocus' => false,
            'autocomplete' => false
        ];
    }

    /**
     * Construct the name of the extension type using the upper camel case
     * naming convention. Extension type name i.e Text will also be suffix
     * with the string (Type) so becomes TextType
     */
    private function buildExtensionName() : string
    {
        $extensionName = lcfirst(str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $this->type . 'Type'))));
        return ucwords($extensionName);
    }

    /**
     * Construct the extension namespace string. Extension name is captured from
     * the buildExtensionName() method name. Extension objects are also instantiated
     * from this method and check to ensure its implementing the correct interface
     * else will throw an invalid argument exception.
     */
    private function buildExtensionObject() : void
    {
        $getExtensionNamespace = __NAMESPACE__ . '\\' . $this->buildExtensionName();
        $getExtensionObject = new $getExtensionNamespace($this->fields);
        if (!$getExtensionObject instanceof FormExtensionTypeInterface) {
            throw new FormBuilderInvalidArgumentException($this->buildExtensionName() . ' is not a valid form extension type object.');
        }

    }

    public function configureOptions(array $options = []) : void
    {
        if (empty($this->type)) {
            throw new FormBuilderInvalidArgumentException('Sorry please set the ' . $this->type . ' property in your extension class.');
        }
        if (!$this->buildExtensionObject()) {
            $defaultWithExtensionOptions = (!empty($options) ? array_merge($this->getBaseOptions(), $options) : $this->getBaseOptions());
            if ($this->fields) { /* field options set from the constructor */
                $this->throwExceptionOnBadInvalidKeys(
                    $this->fields, 
                    $defaultWithExtensionOptions, 
                    $this->buildExtensionName()
                );

                /* Phew!! */
                /* Lets merge the options from the our extension with the fields options */
                /* assigned complete merge to $this->attr class property */
                $this->attr = array_merge($defaultWithExtensionOptions, $this->fields);
            }
        }
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getOptions() : array
    {
        return $this->attr;
    }

    public function getSettings() : array
    {
        $defaults = [
            'before_after_wrapper' => true,
            'container' => true,
            'show_label' => true,
            'new_label' => '',
            'inline_icon' => '',
            'inline_icon_class' => '',
            'inline_flip_icon' => false,
            'description' => ''
        ];
        return (!empty($this->settings) ? array_merge($defaults, $this->settings) : $defaults);
    }

    public function filtering(): string
    {
        return $this->renderHtmlElement($this->attr, $this->options);
    }

    public function view() : string
    {
        switch ($this->getType()) :
            case 'radio' :
                return sprintf("%s", $this->filtering());
                break;
            case 'file' :
                return sprintf(
                    '<div class="js-upload" uk-form-custom>
                    <input type="file" multiple>
                    <button %s type="button" tabindex="-1">%s</button>
                </div>', 
                $this->filtering(),
                $this->options
                );
                break;
            case 'checkbox' :
                return sprintf("\n<input %s>&nbsp;%s\n", $this->filtering(), ($this->settings['checkbox_label'] !='' ? $this->settings['checkbox_label'] : ''));
                break;
            case 'multiple_checkbox' :
                if (
                    isset($this->options) && 
                    is_array($this->options) && 
                    count($this->options) > 0) {
                        foreach ($this->options['choices'] as $key => $option) {    
                           return '<input type="checkbox" class="uk-checkbox" name="visibility[]" id="' . $key . '" value="' . $key . '">&nbsp;' . Stringify::capitalize($key);
                        }   
                }
                break;
            default :
                return sprintf("\n<input %s>\n", $this->filtering());
                break;
        endswitch;
    }

}