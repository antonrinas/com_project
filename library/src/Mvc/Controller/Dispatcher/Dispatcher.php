<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\View\ViewModelInterface;
use Framework\Mvc\View\JsonModelInterface;
use Framework\Mvc\Controller\BaseControllerInterface;
use Framework\Session\SessionInterface;
use Framework\Instantiator\InstantiatorInterface;
use Framework\EventManager\EventManagerInterface;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var JsonModelInterface
     */
    private $jsonModel;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * Dispatcher constructor.
     * @param ResponseInterface $response
     * @param ViewModelInterface $viewModel
     * @param JsonModelInterface $jsonModel
     * @param SessionInterface $session
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        ResponseInterface $response,
        ViewModelInterface $viewModel,
        JsonModelInterface $jsonModel,
        SessionInterface $session,
        InstantiatorInterface $instantiator,
        EventManagerInterface $eventManager
    )
    {
        $this->response = $response;
        $this->viewModel = $viewModel;
        $this->jsonModel = $jsonModel;
        $this->session = $session;
        $this->instantiator = $instantiator;
        $this->eventManager = $eventManager;
    }

    /**
     * @param array $config
     *
     * @return $this|Dispatcher
     *
     * @throws DispatcherException
     */
    public function setConfig($config)
    {
        $this->checkConfig($config);
        $this->config = $config;
        return $this;
    }

    /**
     * @param RequestInterface $request
     *
     * @return Dispatcher
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ResponseInterface
     * @throws DispatcherException
     * @throws \Framework\Instantiator\InstantiatorException
     * @throws \Framework\Mvc\View\ViewModelException
     */
    public function dispatch()
    {
        $route = $this->config;
        $controller = $this->initController();
        $this->response->setHeader('Content-Type', $controller->getContentType());
        $controller->setResponse($this->response);
        $responseContent = call_user_func_array([$controller, $route['method']], $this->request->getParams());
        $this->response = $controller->getResponse();
        $this->response->setContent($responseContent);

        return $this->response;
    }

    /**
     * @return \Framework\Instantiator\FactoryInterface
     *
     * @throws DispatcherException
     * @throws \Framework\Instantiator\InstantiatorException
     * @throws \Framework\Mvc\View\ViewModelException
     */
    private function initController()
    {
        $route = $this->config;
        $moduleName = $route['module'];
        $controllerNamespace = $route['namespace'];
        $controllerName = $route['controller'];
        $className = $moduleName . '\\' . $controllerNamespace . '\\' . $controllerName . 'Controller';
        $methodName = $route['method'];
        $this->checkClassMethodAvalability($className, $methodName);

        $moduleConfig = require (ROOT . DS . 'application' . DS . 'module' . DS . $moduleName . DS . 'config' . DS . 'config.php');

        if ($this->instantiator->findFactory($className)) {
            $controller = $this->instantiator->instantiateFactory($className)->make();
        } else {
            $controller = new $className;
        }

        $this->checkControllerContentType($controller);
        $controller->setRequest($this->request)
                   ->setModuleConfig($moduleConfig)
                   ->setRoute($route);

        if ($controller->getContentType() === 'text/html'){
            $this->viewModel->setModuleConfig($moduleConfig)
                            ->setControllerName($controllerName)
                            ->setMethodName($route['method']);

            $controller->setView($this->viewModel);
        }
        if ($controller->getContentType() === 'application/json'){
            $controller->setView($this->jsonModel);
        }
        $controller->setSession($this->session)
                   ->setEventManager($this->eventManager);

        return $controller;
    }

    /**
     * @param $config
     *
     * @throws DispatcherException
     */
    private function checkConfig($config)
    {
        if (!array_key_exists('module', $config)){
            throw new DispatcherException("Module setting is required. You must provide 'module' key in the route config.");
        }
        if (!array_key_exists('namespace', $config)){
            throw new DispatcherException("Namespace setting is required. You must provide 'namespace' key in the route config.");
        }
        if (!array_key_exists('controller', $config)){
            throw new DispatcherException("Controller name setting is required. You must provide 'controller' key in the route config.");
        }
        if (!array_key_exists('method', $config)){
            throw new DispatcherException("Method mane setting is required. You must provide 'method' key in the route config.");
        }
        if (!array_key_exists('request_method', $config)){
            throw new DispatcherException("Request method setting is required. You must provide 'request_method' key in the route config.");
        }
    }

    /**
     * @param BaseControllerInterface $controller
     *
     * @throws DispatcherException
     */
    private function checkControllerContentType($controller)
    {
        if ($controller->getContentType() !== 'text/html' && $controller->getContentType() !== 'application/json') {
            throw new DispatcherException(
                sprintf("Invalid controller content type %s. Only text/html or application/json are available",
                    $controller->getContentType()
                )
            );
        }
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @throws DispatcherException
     */
    private function checkClassMethodAvalability($className, $methodName)
    {
        if (!class_exists($className)) {
            throw new DispatcherException(sprintf("Controller %s was not found",
                $className
            ));
        }
        if (!method_exists($className, $methodName)) {
            throw new DispatcherException(sprintf("Controller method %s was not found",
                $methodName
            ));
        }
    }
}