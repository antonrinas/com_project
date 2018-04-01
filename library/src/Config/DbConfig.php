<?php

namespace Framework\Config;

class DbConfig implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];

    public function __construct($config = [])
    {
        if (!$config) {
            $configPath = ROOT . DS . 'config' . DS . 'db.php';
            if (!file_exists($configPath)) {
                throw new ApplicationConfigException("Db config file $configPath was not found");
            }
            $config = require (ROOT . DS . 'config' . DS . 'db.php');
        }
        $this->checkConfig($config);
        $this->config = $config;
    }

    /**
     * @param array $config
     */
    private function checkConfig($config)
    {
        if (!array_key_exists('db', $config)){
            throw new ApplicationConfigException("Database settings is required. You must provide 'db' key in the config.");
        }
        if (!array_key_exists('default', $config['db'])){
            throw new ApplicationConfigException("Default database settings is required. You must provide 'default' key in the 'db' config.");
        }

        if (!array_key_exists($config['db']['default'], $config['db'])){
            throw new ApplicationConfigException(
                sprintf("Default database settings is required. You must provide '%s' key in the 'db' config.",
                    $config['db']['default']
                )
            );
        }
        if (!$config['db'][$config['db']['default']]){
            throw new ApplicationConfigException(
                sprintf("Default database settings is required. You must provide settings key '%s' in the 'db' config.",
                    $config['db']['default']
                )
            );
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