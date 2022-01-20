<?php

namespace Evo\Base;

class BaseApplication extends AbstractBaseBootLoader
{
    protected ?string $appPath;
    protected array $appConfig = [];
    protected array $routes = [];

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
    public function setConfig(array $ymlApp): self
    {
        $this->appConfig = $ymlApp;
        return $this;
    }

    /**
     * Return the application configuration as an array of data
     */
    public function getConfig(): array
    {
        return $this->appConfig;
    }

    public function run(): void
    {
        BaseConstants::load($this->app());
        $this->phpVersion();
//        $this->loadErrorHandlers();
//        $this->loadSession();
//        $this->loadCache();
//        $this->loadLogger();
        $this->loadEnvironment();
        //$this->loadThemeBuilder();
//        $this->loadRoutes();
    }
}