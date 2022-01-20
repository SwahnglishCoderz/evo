<?php

namespace Evo\Base;

use Evo\Base\Traits\BootstrapTrait;
use Evo\Container\ContainerFactory;
use Evo\Utility\Singleton;

abstract class AbstractBaseBootLoader extends Singleton
{

    use BootstrapTrait;

    protected BaseApplication $application;

    public function __construct(BaseApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Compare PHP version with the core version ensuring the correct version of
     * PHP and Evo framework is being used at all time in sync.
     */
    protected function phpVersion(): void
    {
        if (version_compare($phpVersion = PHP_VERSION, $coreVersion = $this->app()->getConfig()['app']['app_version'], '<')) {
            die(sprintf('You are running PHP %s, but the core framework requires at least PHP %s', $phpVersion, $coreVersion));
        }
    }

    /**
     * Returns the bootstrap applications object
     */
    public function app(): BaseApplication
    {
        return $this->application;
    }

    /**
     * Load the framework default environment configuration. Most configurations
     * can be done from inside the app.yml file
     *
     * @return void
     */
    protected function loadEnvironment(): void
    {
        $settings = $this->app()->getConfig()['settings'];
        ini_set('default_charset', $settings['default_charset']);
        date_default_timezone_set($settings['default_timezone']);
    }

    /**
     * Initialise the pass our classes to be loaded by the framework dependency
     * container using PHP Reflection
     */
    public static function diGet(string $dependencies)
    {
        $container = (new ContainerFactory())->create();
        if ($container) {
            return $container->get($dependencies);
        }
    }


}