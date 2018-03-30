<?php

namespace Framework;

use Framework\Mvc\Controller\FrontControllerFactory;

class ApplicationFactory implements FactoryInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        $routes = require (ROOT . DS . 'config' . DS . 'routes.php');
        $generalConfig = require (ROOT . DS . 'config' . DS . 'config.php');
        $config = array_merge_recursive($routes, $generalConfig);
        $this->config = $config;
        $this->initEnviroment();
        $this->initTimezone();
    }

    /**
     * @return ApplicationInterface
     *
     * @throws ApplicationException
     */
    public function init()
    {
        $frontControllerFactory = new FrontControllerFactory($this->config);

        return new Application($this->config, $frontControllerFactory->init());
    }

    private function initEnviroment()
    {
        if ($this->config['development']){
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
        }
    }

    private function initTimezone()
    {
        if (array_key_exists('date_default_timezone', $this->config)) {
            date_default_timezone_set($this->config['date_default_timezone']);
        }
    }
}