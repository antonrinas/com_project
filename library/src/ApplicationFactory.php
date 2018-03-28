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
        $routes = require_once (ROOT . DS . 'config' . DS . 'routes.php');
        $generalConfig = require_once (ROOT . DS . 'config' . DS . 'config.php');
        $config = array_merge_recursive($routes, $generalConfig);
        $this->config = $config;
        $this->initEnviroment();
    }

    /**
     * @return ApplicationInterface
     *
     * @throws ApplicationException
     */
    public function getInstance()
    {
        $frontControllerFactory = new FrontControllerFactory($this->config);

        return new Application($this->config, $frontControllerFactory->getInstance());
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
}