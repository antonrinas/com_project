<?php

namespace Framework\Mvc\Controller\Router;


interface RouterInterface
{
    /**
     * @return array
     */
    public function getGetParams();

    /**
     * @return array
     */
    public function getParams();

    /**
     * @return array
     */
    public function getMatchedRoute();
}