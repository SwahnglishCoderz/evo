<?php

namespace Evo\Base;

class AbstractBaseController
{
    protected array $routeParams;

    public function __construct(array $routeParams)
    {
        if ($routeParams)
            $this->routeParams = $routeParams;
    }

    public function toArray(Object $data): array
    {
        return (array)$data;
    }
}