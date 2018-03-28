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
        $currentDateTime = new DateTime(date('Y-m-d H:i:s'));
        $comment = new Comment();
        $comment->setUserName('Anton Rinas')
                ->setContent('комментарий')
                ->setCreatedAt($currentDateTime)
                ->setUpdatedAt($currentDateTime);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        print_r($comment->getId());exit();

        return $this->getView()->setParams([
            'authorized' => $this->getSession()->getUserData() ? true : false,
        ])->render();
    }
}