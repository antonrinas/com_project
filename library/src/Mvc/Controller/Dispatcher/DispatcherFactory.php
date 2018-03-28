<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\FactoryInterface;
use Framework\Mvc\Controller\Response\Response;
use Framework\Mvc\View\ViewModel;
use Framework\Mvc\View\JsonModel;
use Framework\Session\Session;

class DispatcherFactory implements FactoryInterface
{
    /**
     * @return DispatcherInterface
     */
    public function getInstance()
    {
        return new Dispatcher(
            new Response(),
            new ViewModel(),
            new JsonModel(),
            new Session()
        );
    }
}