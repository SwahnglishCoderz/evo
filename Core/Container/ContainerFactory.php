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

namespace Evo\Container;

use Evo\Container\Exception\ContainerInvalidArgumentException;

/** PSR-11 Container */
class ContainerFactory
{
    protected array $providers = [];

    public function __construct()
    {
    }

    /**
     * Factory method which creates the container object.
     */
    public function create(?string $container = null): ContainerInterface
    {
        $containerObject = ($container != null) ? new $container() : new Container();
        if (!$containerObject instanceof ContainerInterface) {
            throw new ContainerInvalidArgumentException($container . ' is not a valid container object');
        }
        return $containerObject;
    }
}
