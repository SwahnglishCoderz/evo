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

namespace Evo\Session\Exception;

use Evo\Base\Exception\BaseUnexpectedValueException;

class SessionUnexpectedValueException extends BaseUnexpectedValueException
{

    public function __construct(
        string $message = null,
        int $code = 0,
        BaseUnexpectedValueException $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
