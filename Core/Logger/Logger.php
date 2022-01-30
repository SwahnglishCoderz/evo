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

use Evo\Logger\Exception\LoggerException;
use Evo\Logger\Handler\LoggerHandlerInterface;
use Evo\Logger\LoggerInterface;
use Throwable;

class Logger implements LoggerInterface
{

    /**
     * Detailed debug information
     */
    public const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    public const INFO = 200;

    /**
     * Uncommon events
     */
    public const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    public const WARNING = 300;

    /**
     * Runtime errors
     */
    public const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    public const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    public const ALERT = 550;

    /**
     * Urgent alert.
     */
    public const EMERGENCY = 600;

    private LoggerHandlerInterface $loggerHandler;

    public function __construct(LoggerHandlerInterface $loggerHandler)
    {
        $this->loggerHandler = $loggerHandler;
    }

    /**
     * @throws LoggerException
     */
    private function writeLog(string $message, array $context): void
    {
        try{
            $this->loggerHandler->write($message, $context);
        }catch(Throwable $throw) {
            throw new LoggerException('An exception was thrown in writing the log to the handler.', 0, $throw);
        }

    }

    /**
     * System is unusable.
     * @throws LoggerException
     */
    public function emergency(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     * @throws LoggerException
     */
    public function alert(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     * @throws LoggerException
     */
    public function critical(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     * @throws LoggerException
     */
    public function error(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     * @throws LoggerException
     */
    public function warning(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Normal but significant events.
     * @throws LoggerException
     */
    public function notice(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     * @throws LoggerException
     */
    public function info(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Detailed debug information.
     * @throws LoggerException
     */
    public function debug(string $message, array $context = array()): void
    {
        $this->writeLog($message, $context);
    }

    /**
     * Logs with an arbitrary level.
     */
    public function log($level, string $message, array $context = array()): void
    {
    }
}
