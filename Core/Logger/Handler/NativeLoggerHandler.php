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
use Evo\Logger\Exception\LoggerHandlerInvalidArgumentException;
use Evo\Logger\LoggerTrait;

class NativeLoggerHandler extends AbstractLoggerHandler
{

    use LoggerTrait;

    private string $file;

    /**
     * @throws LoggerHandlerInvalidArgumentException
     */
    public function __construct(string $file, string $minLevel, array $options = [])
    {
        parent::__construct($file, $minLevel, $options);

        if (!file_exists($this->getLogFile())) {
            if (!touch($this->getLogFile())) {
                throw new LoggerHandlerInvalidArgumentException('Log file ' . $this->getLogFile() . ' can not be created.');
            }
        }
        if (!is_writable($this->getLogFile())) {
            throw new LoggerHandlerInvalidArgumentException('Log file ' . $this->getLogFile() . ' is not writable.');
        }

    }

    public function write(string $level, string $message, array $context = []): void
    {
        if (!$this->logLevelReached($level)) {
            return;
        }
        $line = $this->format($level, $message, $context);
        file_put_contents($this->getFile(), $line, FILE_APPEND | LOCK_EX);
    }

}
