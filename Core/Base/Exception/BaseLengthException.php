<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use LengthException;

class BaseLengthException   extends LengthException  
{ 
    /**
     * Exception thrown if a length is invalid.
     */
    public function __construct(string $message, int $code = 0, LengthException   $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}