<?php

namespace Framework\Mvc\View;

class JsonModel implements JsonModelInterface
{
    /**
     * @var array
     */
    private $params = [];

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
     * @return JsonModel
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        return json_encode($this->params, JSON_HEX_QUOT);
    }
}