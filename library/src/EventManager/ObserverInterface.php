<?php

namespace Framework\EventManager;

use Framework\Instantiator\InstantiatorInterface;

interface ObserverInterface
{
    /**
     * ObserverInterface constructor.
     * @param InstantiatorInterface $instantiator
     */
    public function __construct(InstantiatorInterface $instantiator);

    /**
     * @return InstantiatorInterface
     */
    public function getInstantiator();

    /**
     * @param string $eventName
     * @param array $params
     */
    public function handle($eventName, $params);
}