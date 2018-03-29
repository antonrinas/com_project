<?php

namespace Framework\EventManager;


class EventManager implements EventManagerInterface
{
    /**
     * @var array
     */
    private $eventsMap = [];

    public function __construct($directCall = true)
    {
        if ($directCall) {
            throw new EventManagerException("Direct call is forbidden, use static method 'getInstance' instead");
        }
    }

    public static function getInstance()
    {
        static $eventManager;
        if (!is_object($eventManager)) {
            $eventManager = new EventManager(false);
        }

        return $eventManager;
    }

    /**
     * @return array
     */
    public function getEventsMap()
    {
        return $this->eventsMap;
    }

    /**
     * @param array $eventsMap
     * @return EventManager
     */
    public function setEventsMap($eventsMap)
    {
        $this->eventsMap = $eventsMap;
        return $this;
    }

    /**
     * @param string $name
     * @return EventManagerInterface
     */
    public function addEvent($name)
    {
        if (!array_key_exists($name, $this->eventsMap)) {
            $this->eventsMap[$name] = [];
        }
        return $this;
    }

    /**
     * @param string $name
     * @return EventManagerInterface
     */
    public function removeEvent($name)
    {
        if (!array_key_exists($name, $this->eventsMap)) {
            unset($this->eventsMap[$name]);
        }
        return $this;
    }

    /**
     * @param string $name
     * @param ObserverInterface $observer
     *
     * @return EventManagerInterface
     */
    public function addObserver($name, ObserverInterface $observer)
    {
        if (!array_key_exists($name, $this->eventsMap)) {
            $this->eventsMap[$name] = [];
        }
        $this->eventsMap[$name][] = $observer;
        return $this;
    }

    /**
     * @param $eventName
     *
     * @return EventManagerInterface
     *
     * @throws EventManagerException
     */
    public function fire($eventName, $params = [])
    {
        if (!array_key_exists($eventName, $this->eventsMap)) {
            throw new EventManagerException("Event $eventName was not registered");
        }
        foreach ($this->eventsMap[$eventName] as $observer) {
            $observer->handle($eventName, $params);
        }

        return $this;
    }
}