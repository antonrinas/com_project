<?php

namespace Framework\Mvc\Controller;

use Framework\Session\Session;
use Framework\Mvc\View\JsonModel;
use Framework\Mvc\View\ViewModel;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\EventManager\EventManagerInterface;
use Framework\Session\SessionInterface;
use Framework\Mvc\View\JsonModelInterface;
use Framework\Mvc\View\ViewModelInterface;

abstract class Controller implements ControllerInterface
{
    /**
     * @var string - possible values:
     *                  - application/json - application returns json for API calls
     *                  - text/html - application returns html
     */
    protected $contentType = 'text/html';

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var array
     */
    protected $moduleConfig;

    /**
     * @var ViewModelInterface | JsonModelInterface
     */
    protected $view;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var array
     */
    protected $route;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    public function __construct()
    {
        if ($this->getContentType() === 'text/html') {
            $this->setView(new ViewModel());
        }
        if ($this->getContentType() === 'application/json'){
            $this->setView(new JsonModel());
        }
        $this->setSession(new Session());
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ControllerInterface
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return ControllerInterface
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return array
     */
    public function getModuleConfig()
    {
        return $this->moduleConfig;
    }

    /**
     * @param array $moduleConfig
     *
     * @return ControllerInterface
     */
    public function setModuleConfig($moduleConfig)
    {
        $this->moduleConfig = $moduleConfig;
        return $this;
    }

    /**
     * @return ViewModelInterface | JsonModelInterface
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param ViewModelInterface | JsonModelInterface $view
     *
     * @return ControllerInterface
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param SessionInterface $session
     *
     * @return ControllerInterface
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return array
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param array $route
     *
     * @return ControllerInterface
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @param EventManagerInterface $eventManager
     *
     * @return ControllerInterface
     */
    public function setEventManager($eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
}