<?php

namespace Framework\Config;

class DbConfig implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];

    public function __construct()
    {
        $configPath = ROOT . DS . 'config' . DS . 'db.php';
        if (!file_exists($configPath)) {
            throw new ApplicationConfigException("Db config file $configPath was not found");
        }
        $config = require (ROOT . DS . 'config' . DS . 'db.php');
        $this->chechConfig($config);
        $this->config = $config;
    }

    /**
     * @param $config
     * @throws ApplicationConfigException
     */
    private function chechConfig($config)
    {
        if (!array_key_exists('db', $config)){
            throw new ModelException("Database settings is required. You must provide 'db' key in the config.");
        }
        if (!array_key_exists('default', $config['db'])){
            throw new ModelException("Default database settings is required. You must provide 'default' key in the 'db' config.");
        }

        if (!array_key_exists($config['db']['default'], $config['db'])){
            throw new ModelException(
                sprintf("Default database settings is required. You must provide '%s' key in the 'db' config.",
                    $config['db']['default']
                )
            );
        }
        if (!$config['db'][$config['db']['default']]){
            throw new ModelException(
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