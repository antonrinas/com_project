<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Response\ResponseInterface;

interface FrontControllerInterface
{
    /**
     * @return ResponseInterface
     */
    public function handleRequest();
}