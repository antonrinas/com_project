<?php

namespace Framework\Instantiator;

interface FactoryInterface
{
    /**
     * @param InstantiatorInterface $instantiator
     */
    public function __invoke(InstantiatorInterface $instantiator);
}