<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use BadFunctionCallException;

class BaseBadFunctionCallException  extends BadFunctionCallException 
{ 
    /**
     * Exception thrown if a callback refers to an undefined function or if some arguments are missing.
     */
    public function __construct(string $message, int $code = 0, BadFunctionCallException  $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}