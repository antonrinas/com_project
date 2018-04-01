<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Dispatcher\DispatcherInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;

class FrontController implements FrontControllerInterface
{
    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

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
     */
    public function handleRequest()
    {
        return $this->dispatcher->dispatch();
    }
}