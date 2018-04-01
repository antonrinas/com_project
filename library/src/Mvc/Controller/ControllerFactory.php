<?php

namespace Framework\Mvc\Controller;

use Framework\FactoryInterface;
use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Instantiator\Instantiator;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Config\ApplicationConfig;

class ControllerFactory implements FactoryInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    public function __construct(RequestInterface $request, RouterInterface $router)
    {
        $this->request = $request;
        $this->router = $router;
        $this->instantiator = new Instantiator();
    }

    public function init()
    {
        $route = $this->router->getMatchedRoute();
        $moduleName = $route['module'];
        $controllerNamespace = $route['namespace'];
        $controllerName = $route['controller'];
        $className = $moduleName . '\\' . $controllerNamespace . '\\' . $controllerName . 'Controller';
        $methodName = $route['method'];
        $this->checkClassMethodAvalability($className, $methodName);
        $moduleConfig = ApplicationConfig::getInstance()->getModulesConfig()->getConfig()[$moduleName];
        if ($this->instantiator->findFactory($className)) {
            $controller = $this->instantiator->instantiate($className);
        } else {
            $controller = new $className;
        }
        $this->checkControllerContentType($controller);
        $controller->setRequest($this->request)
                   ->setModuleConfig($moduleConfig)
                   ->setRoute($route);

        if ($controller->getContentType() === 'text/html'){
            $controller->getView()
                       ->setModuleConfig($moduleConfig)
                       ->setControllerName($controllerName)
                       ->setMethodName($route['method']);
        }

        return $controller;
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @throws ControllerException
     */
    private function checkClassMethodAvalability($className, $methodName)
    {
        if (!class_exists($className)) {
            throw new ControllerException(sprintf("Controller %s was not found",
                $className
            ));
        }
        if (!method_exists($className, $methodName)) {
            throw new ControllerException(sprintf("Controller method %s was not found",
                $methodName
            ));
        }
    }

    /**
     * @param BaseControllerInterface $controller
     *
     * @throws ControllerException
     */
    private function checkControllerContentType($controller)
    {
        if ($controller->getContentType() !== 'text/html' && $controller->getContentType() !== 'application/json') {
            throw new ControllerException(
                sprintf("Invalid controller content type %s. Only text/html or application/json are available",
                    $controller->getContentType()
                )
            );
        }
    }
}