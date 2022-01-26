<?php

namespace Evo\Base;

use Evo\Cache\CacheFacade;
use Evo\Logger\LoggerInterface;
use Evo\Session\GlobalManager\GlobalManagerException;
use Evo\Themes\ThemeBuilder;
use Evo\Base\BaseApplication;
use Evo\Logger\LoggerFactory;
use Evo\Router\RouterFactory;
use Evo\Session\SessionFacade;
use Evo\Base\Traits\BootstrapTrait;
use Evo\Container\ContainerFactory;
use Evo\Themes\ThemeBuilderFactory;
use Evo\Session\GlobalManager\GlobalManager;
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
     */
    protected function loadEnvironment(): void
    {
        $settings = $this->app()->getConfig()['settings'];
        ini_set('default_charset', $settings['default_charset']);
        date_default_timezone_set($settings['default_timezone']);
    }

    /**
     * Returns the default route handler mechanism
     */
    protected function defaultRouteHandler(): string
    {
        if (isset($_SERVER))
            return $_SERVER['QUERY_STRING'];
    }

    protected function loadRoutes()
    {
        $factory = new RouterFactory($this->app()->getRouteHandler());
        $factory->create($this->app()->getRouter());
        if (count($this->app()->getRoutes()) > 0) {
            return $factory->buildRoutes($this->app()->getRoutes());
        }
    }

    /**
     * Return the session global variable through a static method which should make
     * accessing the global variable much simpler
     * returns the session object
     * @throws GlobalManagerException
     */
    public static function getSession(): Object
    {
        return GlobalManager::get('session_global');
    }

    /**
     * Get the default session driver defined with the session.yml file
     */
    protected function getDefaultSessionDriver(): string
    {
        return $this->getDefaultSettings($this->app()->getSessions());
    }

    /**
     * Builds the application session component and returns the configured object. Based
     * on the session configuration array.
     */
    protected function loadSession(): Object
    {
        $session = (new SessionFacade(
            $this->app()->getSessions(),
            $this->app()->getSessions()['session_name'],
            $this->app()->getSessionDriver()
        ))->setSession();
        if ($this->application->isSessionGlobal() === true) {
            GlobalManager::set($this->application->getGlobalSessionKey(), $session);

        }
        return $session;
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

    // /**
    //  * Returns an array of the application set providers which will be loaded
    //  * by the dependency container. Which uses PHP Reflection class to
    //  * create objects. With a key property which is defined within the yaml
    //  * providers file
    //  */
    // protected function loadProviders(): array
    // {
    //     return $this->app()->getContainerProviders();
    // }

    // /**
    //  * Get the default cache driver defined with the cache.yml file
    //  */
    // protected function getDefaultCacheDriver(): string
    // {
    //     return $this->getDefaultSettings($this->app()->getCache());
    // }

    // public function loadCache()
    // {
    //     $cache = (new CacheFacade())->create($this->application->getCacheIdentifier(), \Evo\Cache\Storage\NativeCacheStorage::class);
    //     if ($this->application->isCacheGlobal() === true) {
    //         GLobalManager::set($this->application->getGlobalCacheKey(), $cache);
    //     }
    //     return $cache;

    // }

    // protected function loadErrorHandlers(): void
    // {
    //     error_reporting($this->app()->getErrorHandlerLevel());
    //     set_error_handler($this->app()->getErrorHandling()['error']);
    //     set_exception_handler($this->app()->getErrorHandling()['exception']);
    // }

    // protected function loadLogger(): LoggerInterface
    // {
    //     return (new LoggerFactory())
    //         ->create(
    //             $this->app()->getLoggerFile(),
    //             $this->app()->getLogger(),
    //             $this->app()->getLogMinLevel(),
    //             $this->app()->getLoggerOptions()
    //         );
    // }
}