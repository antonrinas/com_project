<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\Mvc\Controller\Response\ResponseInterface;

interface DispatcherInterface
{
    /**
     * @return ResponseInterface
     *
     * @throws DispatcherException
     */
    public function dispatch();
}