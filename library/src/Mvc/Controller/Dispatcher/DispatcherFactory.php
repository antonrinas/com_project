<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\Mvc\Controller\Response\Response;
use Framework\Mvc\Controller\ControllerFactory;
use Framework\Mvc\Controller\Request\Request;
use Framework\FactoryInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\Controller\ControllerInterface;
use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\Request\RequestInterface;

class DispatcherFactory implements FactoryInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ControllerInterface
     */
    private $controller;
    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->request = new Request();
        $this->request->setRequestMethod(array_key_exists('REQUEST_METHOD', $_SERVER) ? $_SERVER['REQUEST_METHOD'] : 'GET')
                      ->setGetParams($this->router->getGetParams())
                      ->setParams($this->router->getParams())
                      ->setPostParams($_POST)
                      ->setCookies($_COOKIE)
                      ->setFiles($_FILES);
        $controllerFactory = new ControllerFactory($this->request, $this->router);
        $this->controller = $controllerFactory->init();
        $this->response = new Response();
    }

    /**
     * @return Dispatcher
     */
    public function init()
    {
        return new Dispatcher(
            $this->request,
            $this->router,
            $this->response,
            $this->controller
        );
    }
}