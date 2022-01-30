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

     /**
      * Set the application session configuration from the session.yml file else
      * load the core session configuration class
      */
     public function setSession(array $ymlSession = [], ?string $newSessionDriver = null, bool $isGlobal = false, ?string $globalKey = null): self
     {
         $this->session = (!empty($ymlSession) ? $ymlSession : (new SessionConfig())->baseConfiguration());
         $this->newSessionDriver = ($newSessionDriver !== null) ? $newSessionDriver : $this->getDefaultSessionDriver();
         $this->isSessionGlobal = $isGlobal;
         $this->globalSessionKey = $globalKey;
         return $this;
     }

     /**
      * If session yml is set from using the setSession from the application
      * bootstrap. Use the user defined session.yml else revert to the core
      * session configuration.
      */
     public function getSessions(): array
     {
         if (empty($this->session)) {
             throw new BaseInvalidArgumentException('You have no session configuration. This is required.');
         }
         return $this->session;
     }

     /**
      * Returns the default session driver from either the core or user defined
      * session configuration. Throws an exception if neither configuration
      * was found
      */
     public function getSessionDriver(): string
     {
         if (empty($this->session)) {
             throw new BaseInvalidArgumentException('You have no session configuration. This is required.');
         }
         return $this->newSessionDriver;
     }

     /**
      * Turn on global session from public/index.php bootstrap file to make the session
      * object available globally throughout the application using the GlobalManager object
      */
     public function isSessionGlobal(): bool
     {
         return isset($this->isSessionGlobal) && $this->isSessionGlobal === true;
     }

     public function getGlobalSessionKey(): string
     {
         if ($this->globalSessionKey !==null && strlen($this->globalSessionKey) < 3) {
             throw new BaseLengthException($this->globalSessionKey . ' is invalid this needs to be more than 3 characters long');
         }
         return ($this->globalSessionKey !==null) ? $this->globalSessionKey : 'session_global';
     }

    // /**
    //  * Set the application cookie configuration from the session.yml file.
    //  */
    // public function setCookie(array $ymlCookie): self
    // {
    //     $this->cookie = $ymlCookie;
    //     return $this;
    // }

    // /**
    //  * Returns the cookie configuration array
    //  */
    // public function getCookie(): array
    // {
    //     return $this->cookie;
    // }

    // /**
    //  * Set the application cache configuration from the session.yml file
    //  */
    // public function setCache(array $ymlCache = [], string $newCacheDriver = null, bool $isGlobal = false, ?string $globalKey = null): self
    // {
    //     $this->cache = (!empty($ymlCache) ? $ymlCache : (new CacheConfig())->baseConfiguration());
    //     $this->newCacheDriver = ($newCacheDriver !== null) ? $newCacheDriver : $this->getDefaultCacheDriver();
    //     $this->isCacheGlobal = $isGlobal;
    //     $this->globalCacheKey = $globalKey;
    //     return $this;
    // }

    // /**
    //  * Returns the cache configuration array
    //  */
    // public function getCacheIdentifier(): string
    // {
    //     return $this->cache['cache_name'] ?? '';
    // }


    // /**
    //  * Returns the cache configuration array
    //  */
    // public function getCache(): array
    // {
    //     return $this->cache;
    // }

    // /**
    //  * Returns the default cache driver from either the core or user defined
    //  * cache configuration. Throws an exception if neither configuration
    //  * was found
    //  */
    // public function getCacheDriver(): string
    // {
    //     if (empty($this->cache)) {
    //         throw new BaseInvalidArgumentException('You have no cache configuration. This is required.');
    //     }
    //     return $this->newCacheDriver;
    // }

    // /**
    //  * Turn on global caching from public/index.php bootstrap file to make the cache
    //  * object available globally throughout the application using the GlobalManager object
    //  */
    // public function isCacheGlobal(): bool
    // {
    //     return isset($this->isCacheGlobal) && $this->isCacheGlobal === true;
    // }

    // public function getGlobalCacheKey(): string
    // {
    //     if ($this->globalCacheKey !==null && strlen($this->globalCacheKey) < 3) {
    //         throw new BaseLengthException($this->globalCacheKey . ' is invalid this needs to be more than 3 characters long');
    //     }
    //     return ($this->globalCacheKey !==null) ? $this->globalCacheKey : 'cache_global';
    // }

    // /**
    //  * Set the application container providers configuration from the session.yml file.
    //  */
    // public function setContainerProviders(array $ymlProviders): self
    // {
    //     $this->containerProviders = $ymlProviders;
    //     return $this;
    // }

    // /**
    //  * Returns the container providers configuration array
    //  */
    // public function getContainerProviders(): array
    // {
    //     return $this->containerProviders;
    // }

    // public function setLogger(string $file, string $handler, string $minLevel, array $options): self
    // {
    //     $this->handler = $handler;
    //     $this->logFile = $file;
    //     $this->logOptions = $options;
    //     $this->logMinLevel = $minLevel;
    //     return $this;
    // }

    // public function getLogger(): string
    // {
    //     return $this->handler;
    // }

    // public function getLoggerFile(): string
    // {
    //     return $this->logFile;
    // }

    // public function getLoggerOptions(): array
    // {
    //     return $this->logOptions;
    // }

    // public function getLogMinLevel(): string
    // {
    //     return $this->logMinLevel;
    // }

    // /**
    //  * Define the framework error handling
    //  */
    // public function setErrorHandler(array $errorHandling, ?int $level = null): self
    // {
    //     $this->errorHandling = $errorHandling;
    //     $this->errorLevel = $level;
    //     return $this;
    // }

    // /**
    //  * Load the error handling configurations from the relevant yaml file
    //  */
    // public function getErrorHandling(): ?array
    // {
    //     if (count($this->errorHandling) > 0) {
    //         return $this->errorHandling;
    //     }
    //     throw new BaseInvalidArgumentException('Error loading the error handling configurations. Please check your method argument.');
    // }

    // public function getErrorHandlerLevel(): int
    // {
    //     if ($this->errorLevel !== null) {
    //         return $this->errorLevel;
    //     }
    //     throw new BaseInvalidArgumentException('Error figuring out the error_level defined within the  error_handler. Ensure this is defined within the second argument within the setErrorHandler method.');
    // }

    public function run(): void
    {
        BaseConstants::load($this->app());
        $this->phpVersion();
        // $this->loadErrorHandlers();
         $this->loadSession();
        // $this->loadCache();
        // $this->loadLogger();
        $this->loadEnvironment();
        //$this->loadThemeBuilder();
        $this->loadRoutes();
    }
}