<?php

namespace Framework\Config;

class GlobalConfig implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * GlobalConfig constructor.
     * @param array $config
     * @throws ApplicationConfigException
     */
    public function __construct($config = [])
    {
        if (!$config) {
            $configPath = ROOT . DS . 'config' . DS . 'config.php';
            if (!file_exists($configPath)) {
                throw new ApplicationConfigException("Global config file $configPath was not found");
            }
            $config = require(ROOT . DS . 'config' . DS . 'config.php');
        }
        $this->checkConfig($config);
        $this->config = $config;
    }

    /**
     * @param $config
     * @throws ApplicationConfigException
     */
    private function checkConfig($config)
    {
        if (!array_key_exists('development', $config)) {
            throw new ApplicationConfigException("'development' key must be provided in config.php");
        }
        if (!array_key_exists('date_default_timezone', $config)) {
            throw new ApplicationConfigException("'date_default_timezone' key must be provided in config.php");
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}