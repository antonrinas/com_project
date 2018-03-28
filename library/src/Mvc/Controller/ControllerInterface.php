<?php

namespace Framework\Mvc\Controller;

use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\View\ViewModelInterface;
use Framework\Session\SessionInterface;

interface ControllerInterface
{
    /**
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * @param RequestInterface $request
     *
     * @return BaseControllerInterface
     */
    public function setRequest($request);

    /**
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * @param ResponseInterface $response
     *
     * @return BaseControllerInterface
     */
    public function setResponse($response);

    /**
     * @return array
     */
    public function getModuleConfig();

    /**
     * @param array $moduleConfig
     *
     * @return BaseControllerInterface
     */
    public function setModuleConfig($moduleConfig);

    /**
     * @return ViewModelInterface | JsonModelInterface
     */
    public function getView();

    /**
     * @param ViewModelInterface | JsonModelInterface $view
     *
     * @return BaseControllerInterface
     */
    public function setView($view);

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @param SessionInterface $session
     *
     * @return BaseControllerInterface
     */
    public function setSession($session);

    /**
     * @return SessionInterface
     */
    public function getSession();

    /**
     * @return array
     */
    public function getRoute();

    /**
     * @param array $route
     *
     * @return BaseControllerInterface
     */
    public function setRoute($route);
}