<?php

namespace Framework\EventManager;

abstract class Observer implements ObserverInterface
{
    /**
     * @var string
     */
    protected $observerName;

    /**
     * @param string $eventName
     * @param array $params
     *
     * @return mixed
     *
     * @throws ObserverException
     */
    public function handle($eventName, $params)
    {
        if (!method_exists($this, $eventName)) {
            throw new ObserverException(sprintf("Observer %s must have %s method",
                $this->observerName,
                $eventName
            ));
        }
        return call_user_func_array([$this, $eventName], $params);;
    }
}