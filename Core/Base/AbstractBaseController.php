<?php

namespace Evo\Base;

class AbstractBaseController
{
    protected array $routeParams;

    public function __construct()
    {}

    public function toArray(Object $data): array
    {
        return (array)$data;
    }
}