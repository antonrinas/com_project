<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\FactoryInterface;
use Framework\Mvc\Controller\Response\Response;
use Framework\Mvc\View\ViewModel;
use Framework\Mvc\View\JsonModel;
use Framework\Session\Session;
use Framework\Instantiator\Instantiator;
use Framework\Mvc\Controller\ControllerFactory;

use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\Request\Request;
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

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->request = new Request();
        $this->initRequest();
    }

    /**
     * @return Dispatcher
     */
    public function init()
    {
        $controllerFactory = new ControllerFactory($this->request, $this->router);
        $controller = $controllerFactory->init();

        return new Dispatcher(
            $this->request,
            $this->router,
            new Response(),
            $controller
        );
    }

    /**
     * Set initial request properties
     */
    private function initRequest()
    {
        $this->request->setRequestMethod($_SERVER['REQUEST_METHOD']);
        $this->request->setGetParams($this->router->getGetParams());
        $this->request->setParams($this->router->getParams());
        $this->request->setPostParams($_POST);
        $this->request->setCookies($_COOKIE);
        $this->request->setFiles($_FILES);
    }
}