<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use OverflowException;

class BaseOverflowException  extends OverflowException  
{ 

    /**
     * Exception thrown when adding an element to a full container.
     */
    public function __construct(string $message, int $code = 0, OverflowException   $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}