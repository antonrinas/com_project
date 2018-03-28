<?php

namespace Framework\Mvc\Controller\Router;

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
     * @param array $routes
     *
     * @throws RouterException
     */
    public function __construct($routes)
    {
        $this->routes = $routes;
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
        foreach ($this->routes as $rules){
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
                $this->matchedRoute = $rules;

                return true;
            }
            $pattern = str_replace("/", "\/", $rules['url']);
            if (preg_match('/' . $pattern . '$/', $this->url)){
                $this->matchedRoute = $rules;

                return true;
            }
        }
        throw new RouterException('Matched route was not found');
    }
}