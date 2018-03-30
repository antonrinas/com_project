<?php

namespace Main\Controller;

use Framework\Mvc\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @return string
     */
    public function index()
    {
        return $this->getView()->render();
    }
}