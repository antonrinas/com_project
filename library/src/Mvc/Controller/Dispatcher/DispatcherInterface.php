<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;

interface DispatcherInterface
{
    /**
     * @param array $config
     *
     * @return $this|Dispatcher
     *
     * @throws DispatcherException
     */
    public function setConfig($config);

    /**
     * @param RequestInterface $request
     *
     * @return Dispatcher
     */
    public function setRequest($request);

    /**
     * @return ResponseInterface
     *
     * @throws DispatcherException
     */
    public function dispatch();
}