<?php

namespace Framework\Mvc\Controller\Router;

use Framework\Config\ConfigInterface;

class Router implements RouterInterface
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var array
     */
    private $matchedRoute;
    /**
     * @var array
     */
    private $getParams = [];
    /**
     * @var array
     */
    private $params = [];
    /**
     * @var
     */
    private $routes;

    /**
     * @return array
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getMatchedRoute()
    {
        return $this->matchedRoute;
    }

    /**
     * Router constructor.
     *
     * @param ConfigInterface $config
     *
     * @throws RouterException
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $parts = parse_url($_SERVER['REQUEST_URI']);
        if (array_key_exists('query', $parts)){
            parse_str($parts['query'], $query);
            $this->getParams = $query;
        }
        $this->url = $parts['path'];

        $this->findMatchedRoute();
    }

    /**
     * @return bool
     *
     * @throws RouterException
     */
    private function findMatchedRoute()
    {
        $routes = $this->config->getConfig()['routes'];

        foreach ($routes as $rules){
            if ($rules['request_method'] !== $_SERVER['REQUEST_METHOD']){
                continue;
            }
            if (array_key_exists('params', $rules)){
                $pattern = str_replace("/", "\/", $rules['url']);
                foreach ($rules['params'] as $paramName => $regex){
                    $pattern = str_replace($paramName, $regex, $pattern);
                }
                if (!preg_match('/' . $pattern . '$/', $this->url)){
                    continue;
                }
                $replacement = [];
                for ($i = 1; $i <= count($rules['params']); $i++) {
                    $replacement[] = '${' . $i . '}';
                }

                $matches = preg_replace('/' . $pattern . '/', implode('|', $replacement), $this->url);
                $this->params = explode('|', $matches);
                $this->checkRoute($rules);
                $this->matchedRoute = $rules;

                return true;
            }
            $pattern = str_replace("/", "\/", $rules['url']);
            if (preg_match('/' . $pattern . '$/', $this->url)){
                $this->checkRoute($rules);
                $this->matchedRoute = $rules;

                return true;
            }
        }
        throw new RouterException('Matched route was not found');
    }

    /**
     * @param array $route
     *
     * @throws RouterException
     */
    private function checkRoute($route)
    {
        if (!array_key_exists('module', $route)){
            throw new RouterException("Module setting is required. You must provide 'module' key in the route config.");
        }
        if (!array_key_exists('namespace', $route)){
            throw new RouterException("Namespace setting is required. You must provide 'namespace' key in the route config.");
        }
        if (!array_key_exists('controller', $route)){
            throw new RouterException("Controller name setting is required. You must provide 'controller' key in the route config.");
        }
        if (!array_key_exists('method', $route)){
            throw new RouterException("Method mane setting is required. You must provide 'method' key in the route config.");
        }
        if (!array_key_exists('request_method', $route)){
            throw new RouterException("Request method setting is required. You must provide 'request_method' key in the route config.");
        }
    }
}