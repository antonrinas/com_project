<?php
/**
 * Created by PhpStorm.
 * User: админ
 * Date: 30.01.2018
 * Time: 13:52
 */

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
    public function render()
    {
        return json_encode($this->params, JSON_HEX_QUOT);
    }
}