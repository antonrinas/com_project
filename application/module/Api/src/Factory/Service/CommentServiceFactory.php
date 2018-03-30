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
     * @param InstantiatorInterface $instantiator
     *
     * @return CommentService
     *
     * @throws \Framework\Instantiator\InstantiatorException
     */
    public function __invoke(InstantiatorInterface $instantiator)
    {
        $entityManager = $instantiator->instantiate(EntityManager::class);
        return new CommentService(
            new CommentRepository($entityManager),
            new PusherService(),
            new Comment()
        );
    }
}