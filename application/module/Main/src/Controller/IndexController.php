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
        /*$options = array(
            'cluster' => 'eu',
            'encrypted' => false
        );
        $pusher = new \Pusher\Pusher(
            'cdb14d8667c152df38cb',
            '6ab7fc3e2dc14d56431c',
            '500230',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('comments', 'added', $data);
        exit();*/

        return $this->getView()->setParams([
            'authorized' => $this->getSession()->getUserData() ? true : false,
        ])->render();
    }
}