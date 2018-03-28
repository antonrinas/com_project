<?php

namespace Framework;

use Framework\Mvc\Controller\FrontControllerInterface;

class Application implements ApplicationInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var FrontControllerInterface
     */
    private $frontController;

    /**
     * Application constructor.
     *
     * @param array $config
     * @param FrontControllerInterface $frontController
     *
     * @throws ApplicationException
     */
    public function __construct($config, FrontControllerInterface $frontController)
    {
        $this->checkConfig($config);
        $this->config = $config;
        $this->frontController = $frontController;
    }

    /**
     * @param array $config
     *
     * @throws ApplicationException
     */
    private function checkConfig($config)
    {
        if (!array_key_exists('development', $config)){
            throw new ApplicationException("Environment settings is required. You must provide 'development' key in the config.");
        }
        if (!array_key_exists('routes', $config)){
            throw new ApplicationException("Routes settings is required. You must provide 'routes' key in the config.");
        }
    }

    public function start()
    {
        $response = $this->frontController->handleRequest();
        echo $response;
    }
}