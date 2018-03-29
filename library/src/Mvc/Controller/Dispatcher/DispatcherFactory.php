<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\FactoryInterface;
use Framework\Mvc\Controller\Response\Response;
use Framework\Mvc\View\ViewModel;
use Framework\Mvc\View\JsonModel;
use Framework\Session\Session;
use Framework\Instantiator\Instantiator;

class DispatcherFactory implements FactoryInterface
{
    /**
     * @return Dispatcher
     *
     * @throws \Framework\Instantiator\InstantiatorException
     */
    public function getInstance()
    {
        return new Dispatcher(
            new Response(),
            new ViewModel(),
            new JsonModel(),
            new Session(),
            new Instantiator()
        );
    }
}