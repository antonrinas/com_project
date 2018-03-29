<?php

namespace Model\Entity;

interface ObserverInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getObserverClassName();

    /**
     * @param string $observerClassName
     * @return ObserverInterface
     */
    public function setObserverClassName($observerClassName);

    /**
     * @return string
     */
    public function getEventName();

    /**
     * @param string $eventName
     * @return ObserverInterface
     */
    public function setEventName($eventName);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $createdAt
     * @return Observer
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $updatedAt
     * @return Observer
     */
    public function setUpdatedAt($updatedAt);
}