<?php

namespace Framework\Config;


class ModulesConfig implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * ModulesConfig constructor.
     * @param array $config
     * @throws ApplicationConfigException
     */
    public function __construct($config = [])
    {
        if (!$config) {
            $configPath = ROOT . DS . 'config' . DS . 'modules.php';
            if (!file_exists($configPath)) {
                throw new ApplicationConfigException("Modules config file $configPath was not found");
            }
            $config = require (ROOT . DS . 'config' . DS . 'modules.php');
        }
        $this->fillAndCheckConfig($config);
    }

    /**
     * @param $config
     * @throws ApplicationConfigException
     */
    private function fillAndCheckConfig($config)
    {
        if (!is_array($config)) {
            throw new ApplicationConfigException("Modules config must be array");
        }
        foreach ($config as $moduleName) {
            $moduleConfigPath = ROOT . DS . 'application' . DS . 'module' . DS . $moduleName . DS . 'config' . DS . 'config.php';
            if (!file_exists($moduleConfigPath)) {
                throw new ApplicationConfigException(sprintf("%s module config file was not found by path %s",
                    $moduleName,
                    $moduleConfigPath
                ));
            }
            $this->config[$moduleName] = require ($moduleConfigPath);
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