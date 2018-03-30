<?php

namespace Main\Factory;

use Framework\Instantiator\InstantiatorInterface;
use Model\Entity\Observer;
use Doctrine\ORM\EntityManager;
use Framework\Mvc\Controller\ControllerInterface;
use Framework\EventManager\EventManager;

abstract class BaseControllerFactory
{
    protected $observers;
    /**
     * @var InstantiatorInterface
     */
    protected $instantiator;

    public function __construct(InstantiatorInterface $instantiator)
    {
        $entityManager = $instantiator->instantiate(EntityManager::class);
        $this->observers = $entityManager->getRepository(Observer::class)->findAll();
        $this->instantiator = $instantiator;
    }

    /**
     * @return mixed
     */
    public function getObservers()
    {
        return $this->observers;
    }

    /**
     * @return InstantiatorInterface
     */
    public function getInstantiator()
    {
        return $this->instantiator;
    }

    /**
     * @param ControllerInterface $controller
     *
     * @return ControllerInterface
     *
     * @throws \Framework\EventManager\EventManagerException
     */
    protected function subscribeObservers(ControllerInterface $controller)
    {
        $eventManager = EventManager::getInstance();
        foreach ($this->observers as $observerInfo) {
            $observerClassName = $observerInfo->getObserverClassName();
            $observer = new $observerClassName($this->instantiator);
            $eventManager->subscribe($observerInfo->getEventName(), $observer);
        }
        $controller->setEventManager($eventManager);

        return $controller;
    }
}