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

namespace Evo\Logger\Handler;

use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Logger\LogLevel;

abstract class AbstractLoggerHandler implements LoggerHandlerInterface
{
    private array $options;
    private string $file;
    private string $minLevel;

    private array $levels = [
        LogLevel::DEBUG,
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING
    ];

    public function __construct(string $file, string $minLevel, array $options = [])
    {
        $this->options = $options;
        $this->minLevel = $minLevel;
        $this->file = $file;
    }

    public function getLogOptions(): array
    {
        return $this->options;
    }

    public function getLogFile(): string
    {
        return $this->file;
    }

    public function getMinLogLevel(): string
    {
        return $this->minLevel;
    }

    public function getLogLevels(): array
    {
        return $this->levels;
    }

}
