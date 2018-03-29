<?php

namespace Framework\EventManager;

interface ObserverInterface
{
    /**
     * @param string $eventName
     * @param array $params
     */
    public function handle($eventName, $params);
}