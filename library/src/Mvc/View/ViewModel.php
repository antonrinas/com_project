<?php

namespace Framework\Mvc\View;

use Framework\Mvc\View\Service\CamelToKebabCase;

class ViewModel implements ViewModelInterface
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $layoutName = 'default';

    /**
     * @var array
     */
    private $moduleConfig;

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var bool
     */
    private $noEscape = false;

    /**
     * @param $config
     *
     * @throws ViewModelException
     */
    private function checkConfig($config)
    {
        if (!array_key_exists('views_path', $config)){
            throw new DispatcherException("Views path setting is required. You must provide 'views_path' key in the module config.");
        }
        if (!array_key_exists('layouts', $config)){
            throw new DispatcherException("Layouts setting is required. You must provide 'layouts' key in the module config.");
        }
        if (!$config['layouts']){
            throw new DispatcherException("You must provide at least one layout in the 'layouts' module config.");
        }
        if (!array_key_exists('default', $config['layouts'])){
            throw new DispatcherException("Default layout is required. You must provide 'default' key in the 'layouts' module config.");
        }
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     *
     * @return ViewModel
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayoutName()
    {
        return $this->layoutName;
    }

    /**
     * @param string $layoutName
     *
     * @return ViewModel
     */
    public function setLayoutName($layoutName)
    {
        $this->layoutName = $layoutName;
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
     * @return ViewModel
     *
     * @throws ViewModelException
     */
    public function setModuleConfig($moduleConfig)
    {
        $this->checkConfig($moduleConfig);
        $this->moduleConfig = $moduleConfig;
        return $this;
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     * @return ViewModel
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return ViewModel
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
        return $this;
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * @param string $viewPath
     *
     * @return ViewModel
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
        return $this;
    }

    /**
     * @param bool $noEscape
     * @return ViewModel
     */
    public function setNoEscape($noEscape)
    {
        $this->noEscape = $noEscape;
        return $this;
    }

    /**
     * @return string
     *
     * @throws ViewModelException
     */
    public function render()
    {
        foreach ($this->params as $key => $value) {
            if ($key === 'content') {
                continue;
            }
            if (!$this->noEscape){
                $this->params[$key] = $this->escape($value);
            }
        }

        if ($this->getViewPath()){
            $completeViewPath = $this->moduleConfig['views_path'].$this->getViewPath();
        } else {
            $controllerFolder = CamelToKebabCase::transform($this->getControllerName());
            $viewName = CamelToKebabCase::transform($this->getMethodName());
            $completeViewPath = $this->moduleConfig['views_path'] . DS . $controllerFolder.DS.$viewName . '.php';
        }
        $content = $this->renderPhpToString($completeViewPath);

        if ($this->getLayoutName()){
            $viewModel = new ViewModel();
            $viewModel->setModuleConfig($this->getModuleConfig())
                      ->setViewPath(DS . '..' . DS . 'layout' . DS . $this->getLayoutName() . '.php')
                      ->setLayoutName(null)
                      ->setParams(['content' => $content,]);

            $content = $viewModel->render();
        }

        return $content;
    }

    private function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
    }

    /**
     * @param $file
     *
     * @return string
     *
     * @throws ViewModelException
     */
    private function renderPhpToString($file)
    {
        if (!is_file($file)){
            throw new ViewModelException(sprintf("View %s was not found",
                $file
            ));
        }
        if (!empty($this->params)) {
            extract($this->params);
        }
        ob_start();
        include $file;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}