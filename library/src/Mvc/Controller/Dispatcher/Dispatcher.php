<?php

namespace Framework\Mvc\Controller\Dispatcher;

use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\View\ViewModelInterface;
use Framework\Mvc\View\JsonModelInterface;
use Framework\Session\SessionInterface;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\ControllerInterface;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var ResponseInterface
     */
    private $response;
    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * Dispatcher constructor.
     * @param RequestInterface $request
     * @param RouterInterface $router
     * @param ResponseInterface $response
     * @param ControllerInterface $controller
     */
    public function __construct(
        RequestInterface $request,
        RouterInterface $router,
        ResponseInterface $response,
        ControllerInterface $controller
    )
    {
        $this->request = $request;
        $this->router = $router;
        $this->response = $response;
        $this->controller = $controller;
    }

    /**
     * @return ResponseInterface
     */
    public function dispatch()
    {
        $route = $this->router->getMatchedRoute();
        $this->response->setHeader('Content-Type', $this->controller->getContentType());
        $this->controller->setResponse($this->response);
        $responseContent = call_user_func_array([$this->controller, $route['method']], $this->request->getParams());
        $this->response = $this->controller->getResponse();
        $this->response->setContent($responseContent);

        return $this->response;
    }
}