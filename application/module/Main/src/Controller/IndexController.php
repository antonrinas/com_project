<?php

namespace Main\Controller;

use Framework\Mvc\Controller\Controller;

class IndexController extends Controller
{
    /**
     * IndexController constructor.
     * Always use parent::__construct() before your logic in __construct()
     */

    /**
     * @return string
     */
    public function index()
    {
        return $this->getView()->render();
    }
}