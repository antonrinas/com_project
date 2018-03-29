<?php

namespace Api\Factory\Controller;

use Api\Controller\CommentController;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Instantiator\FactoryInterface;
use Api\Service\CommentServiceInterface;
use Api\Validator\Comment as CommentValidator;

class CommentControllerFactory implements FactoryInterface
{
    /**
     * @var mixed
     */
    private $object;

    public function __construct(InstantiatorInterface $instantiator)
    {
        $commentService = $instantiator->instantiateFactory(CommentServiceInterface::class)->make();
        $this->object = new CommentController($commentService, new CommentValidator);
    }

    public function make()
    {
        return $this->object;
    }
}