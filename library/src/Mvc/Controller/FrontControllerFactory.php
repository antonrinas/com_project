<?php

namespace Framework\Mvc\Controller;

use Framework\FactoryInterface;
use Framework\Mvc\Controller\Router\Router;
use Framework\Mvc\Controller\Request\Request;
use Framework\Mvc\Controller\Dispatcher\DispatcherFactory;


class FrontControllerFactory implements FactoryInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config['routes'];
    }

    /**
     * @return FrontController
     */
    public function getInstance()
    {
        $router = new Router($this->config);
        $request = new Request();
        $dispatcherFactory = new DispatcherFactory();
        $dispatcher = $dispatcherFactory->getInstance();

        return new FrontController($this->config, $router, $request, $dispatcher);
    }
}