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
     * @param DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface $dispatcher)
    {
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
        return $this->dispatcher->dispatch();
    }
}