<?php

namespace Api\Factory\Controller;

use Api\Controller\CommentController;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Instantiator\FactoryInterface;
use Api\Service\CommentServiceInterface;
use Api\Validator\Comment as CommentValidator;
use Main\Factory\BaseControllerFactory;

class CommentControllerFactory extends BaseControllerFactory implements FactoryInterface
{
    public function __invoke(InstantiatorInterface $instantiator)
    {
        $commentService = $instantiator->instantiate(CommentServiceInterface::class);
        $controller = new CommentController($commentService, new CommentValidator);

        return $this->subscribeObservers($controller);
    }
}