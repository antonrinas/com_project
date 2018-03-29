<?php

namespace Api\Factory\Service;

use Api\Service\CommentService;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Instantiator\FactoryInterface;
use Doctrine\ORM\EntityManager;
use Model\Repository\CommentRepository;
use Main\Service\PusherService;

class CommentServiceFactory implements FactoryInterface
{
    /**
     * @var mixed
     */
    private $object;

    public function __construct(InstantiatorInterface $instantiator)
    {
        $entityManager = $instantiator->instantiateFactory(EntityManager::class)->make();
        $commentRepository = new CommentRepository($entityManager);
        $pusherService = new PusherService();
        $this->object = new CommentService($entityManager, $commentRepository, $pusherService);
    }

    public function make()
    {
        return $this->object;
    }
}