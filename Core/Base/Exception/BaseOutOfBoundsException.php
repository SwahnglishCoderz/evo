<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use OutOfBoundsException;

class BaseOutOfBoundsException extends OutOfBoundsException
{ 
    /**
     * Exception thrown if a value is not a valid key. This represents errors that cannot be 
     * detected at compile time.
     */
    public function __construct(string $message, int $code = 0, OutOfBoundsException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}