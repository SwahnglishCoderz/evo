<?php

declare(strict_types = 1);

namespace Evo\Base\Exception;

use Exception;

class BaseException extends Exception
{ 

    /**
     * Main class constructor. Which allow overriding of SPL exceptions to add custom
     * exact message within core framework.
     */
    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}