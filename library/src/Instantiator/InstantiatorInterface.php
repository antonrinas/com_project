<?php

namespace Framework\Instantiator;

interface InstantiatorInterface
{
    /**
     * @param string $className
     *
     * @return bool|mixed
     */
    public function findFactory($className);

    /**
     * @param $className
     *
     * @return FactoryInterface
     *
     * @throws InstantiatorException
     */
    public function instantiate($className);
}