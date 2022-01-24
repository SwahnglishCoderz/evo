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

namespace Evo\ValidationRule\Event;

use Evo\EventDispatcher\Event;

class ValidateRuleEvent extends Event
{
    public const NAME = 'magmaCore.validation.rule_event.validation_rule_event';
    private array $context;
    private Object $controller;
    private string $method;

    /**
     * Main class constructor method. assigning properties to constructor arguments
     */
        public function __construct(string $method, array $context, Object $controllerObject)
        {
            $this->method = $method;
            $this->context = $context;
            $this->controller = $controllerObject;
        }
    
        /**
         * Returns the namespace method
         */
        public function getMethod(): string
        {
            return $this->method;
        }
    
        /**
         * Returns the contextual data from the method
         */
        public function getContext(): array
        {
            return $this->context;
        }
    
        /**
         * Returns the current controller object with access to all its methods and property
         */
        public function getObject(): Object
        {
            return $this->controller;
        }
    

}
