<?php

namespace Main\Controller;

use Model\Entity\Comment;

class IndexController extends BaseController
{
    /**
     * @return string
     */
    public function index()
    {
        $comment = new Comment();
        $comment->setUserName('Anton Rinas')
                ->setContent('комментарий')
                ->setCreatedAt(date('Y-m-d H:i:s'))
                ->setUpdatedAt(date('Y-m-d H:i:s'));

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        print_r($comment->getId());exit();

        return $this->getView()->setParams([
            'authorized' => $this->getSession()->getUserData() ? true : false,
        ])->render();
    }
}