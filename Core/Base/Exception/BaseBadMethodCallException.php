<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use BadMethodCallException;

class BaseBadMethodCallException extends BadMethodCallException
{ 
    /**
     * Exception thrown if a callback refers to an undefined method or if some arguments are 
     * missing.
     */
    public function __construct(string $message, int $code = 0, BadMethodCallException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}