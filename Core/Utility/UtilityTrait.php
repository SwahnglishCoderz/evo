<?php

namespace Evo\Utility;

use Evo\Utility\Yaml;

trait UtilityTrait
{
    

    public function security(string $key): mixed
    {
        return Yaml::file('app')['security'][$key];
    }

    public static function appSecurity(string $key): mixed
    {
        return Yaml::file('app')['security'][$key];
    }


}