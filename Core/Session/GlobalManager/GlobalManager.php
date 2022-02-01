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

namespace Evo\Session\GlobalManager;

class GlobalManager implements GlobalManagerInterface
{
    public static function set(string $name, $context): void
    {
        if ($name !== '') {
            $GLOBALS[$name] = $context;
        }
    }

    public static function get(string $name)
    {
        self::isGlobalValid($name);
        return $GLOBALS[$name];
    }

    /**
     * Check whether the global name is set else throw an exception
     * @throws GlobalManagerException
     */
    protected static function isGlobalValid(string $name): void
    {
        if (!isset($GLOBALS[$name]) || empty($name)) {
            throw new GlobalManagerException("Invalid global. Please ensure you've set the global state for " . $name . ' And the feature is set to true from your public/index.php file.');
        }
    }
}
