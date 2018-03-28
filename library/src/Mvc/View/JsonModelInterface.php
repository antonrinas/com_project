<?php

namespace Framework\Mvc\View;


interface JsonModelInterface
{
    /**
     * @return array
     */
    public function getParams();

    /**
     * @param array $params
     *
     * @return JsonModelInterface
     */
    public function setParams($params);

    /**
     * @return string
     */
    public function render();
}