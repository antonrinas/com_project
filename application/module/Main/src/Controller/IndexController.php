<?php

namespace Main\Controller;

class IndexController extends BaseController
{
    /**
     * @return string
     */
    public function index()
    {
        return $this->getView()->setParams([
            'authorized' => $this->getSession()->getUserData() ? true : false,
        ])->render();
    }
}