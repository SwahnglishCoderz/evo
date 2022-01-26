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

use Evo\Container\Exception\DependencyIsNotInstantiableException;
use Evo\Container\Exception\DependencyHasNoDefaultValueException;
use ReflectionClass;
use Closure;
use ReflectionException;
use ReflectionParameter;

/** PSR-11 Container */
class Container implements ContainerInterface, SettableInterface
{

    /** */
    protected array $instance = [];
    /** */
    protected array $services = [];
    /** @var Object */
    protected object $service;
    /** */
    protected array $unregister = [];

    /**
     * @inheritdoc
     * @param string $id
     * @param Closure $concrete
     * @return void
     */
    public function set(string $id, Closure $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $id;
        }
        $this->instance[$id] = $concrete;
    }

    /**
     * @inheritdoc
     * @param string $id Identifier of the entry to look for.
     * @return Entry.
     * @throws ContainerExceptionInterface Error while retrieving the entry.*@throws ReflectionException
     * @throws NotFoundExceptionInterface|ReflectionException  No entry was found for **this** identifier.
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            $this->set($id);
        }
        $concrete = $this->instance[$id];
        return $this->resolved($concrete);
    }

    /**
     * @inheritdoc
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instance[$id]);
    }

    /**
     * Resolves a single dependency
     *
     * @param string $concrete
     * @return mixed
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    protected function resolved(string $concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        $reflection = new ReflectionClass($concrete);
        /* Check to see whether the class is instantiable */
        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class " . $concrete . " is not instantiable.");
        }

        /* Get the class constructor */
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            /* Return the new instance */
            return $reflection->newInstance();
        }

        /* Get the constructor parameters */
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $reflection);
        /* Get the new instance with dependency resolved */
        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Resolves all the dependencies
     *
     * @param ReflectionParameter $parameters
     * @param ReflectionClass $reflection
     * @return array
     * @throws DependencyHasNoDefaultValueException|ReflectionException
     */
    protected function getDependencies($parameters, ReflectionClass $reflection): array
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            //$dependency = $parameter->getClass();
            $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? new ReflectionClass($parameter->getType()->getName())
                : null;
            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyHasNoDefaultValueException('Sorry cannot resolve class dependency ' . $parameter->name);
                }
            } elseif (!$reflection->isUserDefined()) {
                $this->set($dependency->name);
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }

    /**
     * @param array $services
     * @return self
     */
    public function SetServices(array $services = []): self
    {
        if ($services)
            $this->services = $services;

        return $this;
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param array $args
     * @return self
     */
    public function unregister(array $args = []): self
    {
        $this->unregister = $args;
        return $this;
    }
}
