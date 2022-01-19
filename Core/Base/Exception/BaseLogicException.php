<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use LogicException;

class BaseLogicException extends LogicException
{ 
    /**
     * Exception that represents error in the program logic. This kind of exception should
     * lead directly to a fix in your code.
     */
    public function __construct(string $message, int $code = 0, LogicException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}