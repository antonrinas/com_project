<?php

namespace Framework\EventManager;

interface EventManagerInterface
{
    /**
     * @return EventManagerInterface
     */
    public static function getInstance();

    /**
     * @return array
     */
    public function getEventsMap();

    /**
     * @param array $eventsMap
     * @return EventManagerInterface
     */
    public function setEventsMap($eventsMap);

    /**
     * @param string $name
     * @return EventManagerInterface
     */
    public function addEvent($name);

    /**
     * @param string $name
     * @return EventManagerInterface
     */
    public function removeEvent($name);

    /**
     * @param name $name
     * @param ObserverInterface $observer
     * @return EventManagerInterface
     */
    public function addObserver($name, ObserverInterface $observer);

    /**
     * @param string $name
     * @return EventManagerInterface
     */
    public function fire($eventName);
}