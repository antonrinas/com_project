<?php

namespace Api\Factory\Service;

use Api\Service\CommentService;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Instantiator\FactoryInterface;
use Doctrine\ORM\EntityManager;
use Model\Repository\CommentRepository;
use Main\Service\PusherService;
use Model\Entity\Comment;

class CommentServiceFactory implements FactoryInterface
{
    /**
     * @var mixed
     */
    private $object;

    public function __construct(InstantiatorInterface $instantiator)
    {
        $entityManager = $instantiator->instantiateFactory(EntityManager::class)->make();
        $this->object = new CommentService(
            new CommentRepository($entityManager),
            new PusherService(),
            new Comment()
        );
    }

    public function make()
    {
        return $this->object;
    }
}