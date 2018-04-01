<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.04.2018
 * Time: 10:49
 */

namespace Framework\Config;


class RoutesConfig implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * RoutesConfig constructor.
     * @param array $config
     * @throws ApplicationConfigException
     */
    public function __construct($config = [])
    {
        if (!$config) {
            $configPath = ROOT . DS . 'config' . DS . 'routes.php';
            if (!file_exists($configPath)) {
                throw new ApplicationConfigException("Routes config file $configPath was not found");
            }
            $config = require (ROOT . DS . 'config' . DS . 'routes.php');
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
        if (!is_array($config)) {
            throw new ApplicationConfigException("Routes config must be array");
        }
        if (!array_key_exists('routes', $config)) {
            throw new ApplicationConfigException("'routes' key must be provided in routes.php");
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