<?php

namespace Framework\Mvc\Controller;

use Framework\FactoryInterface;
use Framework\Mvc\Controller\Router\Router;
use Framework\Mvc\Controller\Router\RouterException;
use Framework\Mvc\Controller\Dispatcher\DispatcherFactory;
use Framework\Config\ApplicationConfig;
use Framework\Config\ApplicationConfigException;
use Framework\Instantiator\InstantiatorException;

class FrontControllerFactory implements FactoryInterface
{
    /**
     * @return FrontController
     * @throws RouterException
     * @throws ApplicationConfigException
     * @throws InstantiatorException
     */
    public function init()
    {
        $router = new Router(ApplicationConfig::getInstance()->getRoutesConfig());
        $dispatcherFactory = new DispatcherFactory($router);
        $dispatcher = $dispatcherFactory->init();

        return new FrontController($dispatcher);
    }
}