<?php

namespace Framework\Config;

class ApplicationConfig implements ApplicationConfigInterface
{
    /**
     * @var array
     */
    private $globaConfig;
    /**
     * @var array
     */
    private $dbConfig;
    /**
     * @var array
     */
    private $modulesConfig;
    /**
     * @var array
     */
    private $routesConfig;

    /**
     * ApplicationConfig constructor.
     * @param bool $directCall
     * @throws ApplicationConfigException
     */
    public function __construct($directCall = true)
    {
        if ($directCall) {
            throw new ApplicationConfigException("Direct call is forbidden, use static method 'getInstance' instead");
        }

    }

    /**
     * @return ApplicationConfig
     *
     * @throws ApplicationConfigException
     */
    public static function getInstance()
    {
        static $applicationConfig;
        if (!is_object($applicationConfig)) {
            $applicationConfig = new ApplicationConfig(false);
        }

        return $applicationConfig;
    }

    /**
     * @return GlobalConfig
     *
     * @throws ApplicationConfigException
     */
    public function getGlobalConfig()
    {
        if (!$this->globaConfig) {
            $this->globaConfig = new GlobalConfig();
        }
        return $this->globaConfig;
    }

    /**
     * @return DbConfig
     *
     * @throws ApplicationConfigException
     */
    public function getDbConfig()
    {
        if (!$this->dbConfig) {
            $this->dbConfig = new DbConfig();
        }
        return $this->dbConfig;
    }

    /**
     * @return ModulesConfig
     *
     * @throws ApplicationConfigException
     */
    public function getModulesConfig()
    {
        if (!$this->modulesConfig) {
            $this->modulesConfig = new ModulesConfig();
        }
        return $this->modulesConfig;
    }

    /**
     * @return RoutesConfig
     *
     * @throws ApplicationConfigException
     */
    public function getRoutesConfig()
    {
        if (!$this->routesConfig) {
            $this->routesConfig = new RoutesConfig();
        }
        return $this->routesConfig;
    }
}