<?php

namespace Evo\Base;

use Evo\Base\Exception\BaseLengthException;
use Evo\Cache\CacheConfig;
use Evo\Base\BaseConstants;
use Evo\Session\SessionConfig;
use Evo\Base\AbstractBaseBootLoader;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\System\Config;;

class BaseApplication extends AbstractBaseBootLoader
{
    protected ?string $appPath;
    protected array $appConfig = [];
    protected array $session;
    protected bool $isSessionGlobal = false;
    protected ?string $globalSessionKey = null;
    protected array $cookie = [];
    protected array $cache = [];
    protected bool $isCacheGlobal = false;
    protected ?string $globalCacheKey = null;
    protected array $routes = [];
    protected array $containerProviders = [];
    protected ?string $routeHandler;
    protected ?string $newRouter;
    protected ?string $theme;
    protected ?string $newCacheDriver;
    protected string $handler;
    protected string $logFile;
    protected array $logOptions = [];
    protected string $logMinLevel;
    protected array $themeBuilderOptions = [];
    protected array$errorHandling = [];
    protected ?int $errorLevel = null;

    public function __construct()
    {
        parent::__construct($this);
    }

    /**
     * Set the project root path directory
     */
    public function setPath(string $rootPath): self
    {
        $this->appPath = $rootPath;
        return $this;
    }

    /**
     * Return the document root path
     */
    public function getPath(): string
    {
        return $this->appPath;
    }

    /**
     * Set the application main configuration from the project app.yml file
     */
    public function setConfig(): self
    {
        $this->appConfig = Config::APP;
        return $this;
    }

    /**
     * Return the application configuration as an array of data
     */
    public function getConfig(): array
    {
        return $this->appConfig;
    }

    /**
     * Set the application routes configuration from the session.yml file.
     */
    public function setRoutes(?string $routeHandler = null, ?string $newRouter = null): self
    {
        $this->routes = Config::ROUTES;
        $this->routeHandler = ($routeHandler !== null) ? $routeHandler : $this->defaultRouteHandler();
        $this->newRouter = ($newRouter !== null) ? $newRouter : '';
        return $this;
    }

    /**
     * Returns the application route configuration array
     */
    public function getRoutes(): array
    {
        if (count($this->routes) < 0) {
            throw new BaseInvalidArgumentException('No routes detected within your routes.yml file');
        }
        return $this->routes;
    }

    /**
     * Returns the application route handler mechanism
     */
    public function getRouteHandler(): string
    {
        if ($this->routeHandler === null) {
            throw new BaseInvalidArgumentException('Please set your route handler.');
        }
        return $this->routeHandler;
    }

    /**
     * Get the new router object fully qualified namespace
     */
    public function getRouter(): string
    {
        if ($this->newRouter === null) {
            throw new BaseInvalidArgumentException('No new router object was defined.');
        }
        return $this->newRouter;
    }

    public function run(): void
    {
        BaseConstants::load($this->app());
        $this->phpVersion();
        $this->loadEnvironment();
        $this->loadRoutes();
    }
}