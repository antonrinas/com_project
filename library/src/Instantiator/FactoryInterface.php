<?php

namespace Framework\Instantiator;

interface FactoryInterface
{
    /**
     * @param InstantiatorInterface $instantiator
     */
    public function __construct(InstantiatorInterface $instantiator);

    /**
     * @return mixed
     */
    public function make();
}