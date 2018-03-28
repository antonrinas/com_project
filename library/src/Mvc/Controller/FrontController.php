<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\Dispatcher\DispatcherInterface;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;

class FrontController implements FrontControllerInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * FrontController constructor.
     * @param $config
     * @param RouterInterface $router
     * @param RequestInterface $request
     * @param DispatcherInterface $dispatcher
     */
    public function __construct(
        $config,
        RouterInterface $router,
        RequestInterface $request,
        DispatcherInterface $dispatcher)
    {
        $this->config = $config;
        $this->router = $router;
        $this->request = $request;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return ResponseInterface
     *
     * @throws Dispatcher\DispatcherException
     *
     * @throws \Framework\Mvc\View\ViewModelException
     */
    public function handleRequest()
    {
        $this->initRequest();
        return $this->dispatch();
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

    /**
     * @return ResponseInterface
     *
     * @throws Dispatcher\DispatcherException
     *
     * @throws \Framework\Mvc\View\ViewModelException
     */
    private function dispatch()
    {
        return $this->dispatcher->setConfig($this->router->getMatchedRoute())
                                ->setRequest($this->request)
                                ->dispatch();
    }
}