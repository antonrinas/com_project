<?php

namespace Main\Controller;

use Model\Entity\Comment;
use \DateTime;

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