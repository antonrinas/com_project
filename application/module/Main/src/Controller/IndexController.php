<?php

namespace Main\Controller;

use Framework\Mvc\Controller\BaseController;
use Framework\Mvc\Model\ModelFactory;

class IndexController extends BaseController
{
    /**
     * @return string
     */
    public function index()
    {
        print_r('asdgasdg');exit();

        return $this->getView()->setParams([
            'authorized' => $this->getSession()->getUserData() ? true : false,
        ])->render();
    }
}