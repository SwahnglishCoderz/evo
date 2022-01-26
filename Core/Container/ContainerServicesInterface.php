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

/** PSR-11 Container */
interface ContainerServicesInterface
{

    /**
     * Set Class services
     *
     * @param array $services
     * @return self
     */
    public function setServices(array $services = []): self;

    /**
     * Get class service or services
     */
    public function getServices(): array;

    /**
     * Unregister a service from being instantiable
     *
     * @param array $args - optional argument
     * @return ContainerServicesInterface ;
     */
    public function unregister(array $args = []): self;

    /**
     * Register service or services with auto-wiring
     */
    public function register();
}
