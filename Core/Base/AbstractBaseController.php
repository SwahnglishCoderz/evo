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

namespace Evo\Base;

use Evo\Base\Traits\ControllerTrait;
use Evo\Container\ContainerInterface;

class AbstractBaseController
{
    use ControllerTrait;

    protected ContainerInterface $container;
    protected array $routeParams;

    public function __construct(array $routeParams)
    {
        if ($routeParams)
            $this->routeParams = $routeParams;
    }

    public function setContainer(ContainerInterface $container): ContainerInterface
    {
        $previous = $this->container;
        $this->container = $container;
        return $previous;
    }

    /**
     * Return the current controller name as a string
     */
    public function thisRouteController(): string
    {
        return isset($this->routeParams['controller']) ? strtolower($this->routeParams['controller']) : '';
    }

    /**
     * Return the current controller action as a string
     */
    public function thisRouteAction(): string
    {
        return isset($this->routeParams['action']) ? strtolower($this->routeParams['action']) : '';
    }

    /**
     * Return the current controller namespace as a string
     */
    public function thisRouteNamespace(): string
    {
        return isset($this->routeParams['namespace']) ? strtolower($this->routeParams['namespace']) : '';
    }

    /**
     * Return the current controller token as a string
     */
    public function thisRouteToken(): ?string
    {
        $token = $this->routeParams['token'] ?? null;
        return (string)$token;
    }

    /**
     * Return the current controller route ID if set as an int
     */
    public function thisRouteID(): int
    {
        $ID = $this->routeParams['id'] ?? false;
        return intval($ID);
    }

    public function toArray(Object $data): array
    {
        return (array)$data;
    }

}