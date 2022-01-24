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

namespace Evo\Logger;

use Evo\Logger\Exception\LoggerHandlerInvalidArgumentException;
use Evo\Logger\Handler\LoggerHandlerInterface;
use Evo\Logger\Handler\NativeLoggerHandler;
use Evo\Logger\LoggerInterface;
use Evo\Logger\Logger;
use function get_class;

class LoggerFactory
{
    /**
     * @throws LoggerHandlerInvalidArgumentException
     */
    public function create(?string $file, string $handler, ?string $defaultLogLevel, array $options = []): LoggerInterface
    {
        $newHandler = ($handler !=null) ? new $handler($file, $defaultLogLevel, $options) : new NativeLoggerHandler($file, $defaultLogLevel, $options);
        if (!$newHandler instanceof LoggerHandlerInterface) {
            throw new LoggerHandlerInvalidArgumentException(get_class($newHandler) . ' is invald as it does not implement the correct interface.');
        }
        return new Logger($newHandler);
    }

}