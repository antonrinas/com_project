<?php

namespace Framework;

use Framework\Mvc\Controller\FrontControllerFactory;
use Framework\Config\ApplicationConfig;

class ApplicationFactory implements FactoryInterface
{
    /**
     * @return Application
     *
     * @throws Config\ApplicationConfigException
     */
    public function init()
    {
        $frontControllerFactory = new FrontControllerFactory();
        return new Application(ApplicationConfig::getInstance(), $frontControllerFactory->init());
    }
}