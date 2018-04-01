<?php

namespace Framework;

use Framework\Mvc\Controller\FrontControllerInterface;
use Framework\Config\ApplicationConfigInterface;

class Application implements ApplicationInterface
{
    /**
     * @var ApplicationConfigInterface
     */
    private $config;

    /**
     * @var FrontControllerInterface
     */
    private $frontController;

    /**
     * Application constructor.
     *
     * @param ApplicationConfigInterface $config
     * @param FrontControllerInterface $frontController
     *
     * @throws Config\ApplicationConfigException
     */
    public function __construct(ApplicationConfigInterface $config, FrontControllerInterface $frontController)
    {
        $this->config = $config;
        $this->initEnviroment();
        $this->initTimezone();
        $this->frontController = $frontController;
    }

    /**
     * @return void
     */
    public function start()
    {
        $response = $this->frontController->handleRequest();
        echo $response;
    }

    /**
     * @throws Config\ApplicationConfigException
     */
    private function initEnviroment()
    {
        if ($this->config->getGlobalConfig()->getConfig()['development']){
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
        }
    }

    /**
     * @throws Config\ApplicationConfigException
     */
    private function initTimezone()
    {
        date_default_timezone_set($this->config->getGlobalConfig()->getConfig()['date_default_timezone']);
    }
}