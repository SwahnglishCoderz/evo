<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use UnderflowException;

class BaseUnderflowException extends UnderflowException 
{ 

    /**
     * Exception thrown when performing an invalid operation on an empty container, 
     * such as removing an element.
     */
    public function __construct(string $message, int $code = 0, UnderflowException  $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}