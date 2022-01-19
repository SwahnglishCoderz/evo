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

namespace Evo\Collection;

class CollectionProxy
{

    /** @var - the collection being used */
    protected CollectionInterface $collection;
    /** @var string - the method being proxied */
    protected string $method;

    /**
     * Create a new proxy instance
     */
    public function __construct(CollectionInterface $collection, string $method)
    {
        $this->method = $method;
        $this->collection = $collection;
    }

    /**
     * Proxy accessing an attribute onto the collection items.
     */
    public function __get(string $key)
    {
        return $this->collection->{$this->method}(function ($value) use ($key) {
            return is_array($value) ? $value[$key] : $value->{$key};
        });
    }

    /**
     * Proxy a method call onto the collection items.
     */
    public function __call(string $method, array $parameters)
    {
        return $this->collection->{$this->method}(function ($value) use ($method, $parameters) {
            return $value->{$method}(...$parameters);
        });
    }
}
