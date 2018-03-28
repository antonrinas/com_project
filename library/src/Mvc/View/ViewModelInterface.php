<?php

namespace Framework\Mvc\View;


interface ViewModelInterface
{
    /**
     * @return array
     */
    public function getParams();

    /**
     * @param array $params
     *
     * @return ViewModel
     */
    public function setParams($params);

    /**
     * @return string
     */
    public function getLayoutName();

    /**
     * @param string $layoutName
     *
     * @return ViewModel
     */
    public function setLayoutName($layoutName);

    /**
     * @return array
     */
    public function getModuleConfig();

    /**
     * @param array $moduleConfig
     *
     * @return ViewModel
     *
     * @throws ViewModelException
     */
    public function setModuleConfig($moduleConfig);

    /**
     * @return string
     */
    public function getControllerName();

    /**
     * @param string $controllerName
     * @return ViewModel
     */
    public function setControllerName($controllerName);

    /**
     * @return string
     */
    public function getMethodName();

    /**
     * @param string $methodName
     *
     * @return ViewModel
     */
    public function setMethodName($methodName);

    /**
     * @return string
     */
    public function getViewPath();

    /**
     * @param string $viewPath
     *
     * @return ViewModel
     */
    public function setViewPath($viewPath);

    /**
     * @param bool $noEscape
     * @return ViewModel
     */
    public function setNoEscape($noEscape);

    /**
     * @return string
     *
     * @throws ViewModelException
     */
    public function render();
}