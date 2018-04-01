<?php

namespace Framework\Instantiator;

use Framework\Config\ApplicationConfig;

class Instantiator implements InstantiatorInterface
{
    private $factoriesMap = [];

    /**
     * Instantiator constructor.
     * @throws \Framework\Config\ApplicationConfigException
     */
    public function __construct()
    {
        foreach (ApplicationConfig::getInstance()->getModulesConfig()->getConfig() as $namespace => $config){
            if (!array_key_exists('factories', $config)) {
                continue;
            }
            if (is_array($config['factories'])) {
                $this->factoriesMap = array_merge($this->factoriesMap, $config['factories']);
            }
        }
    }

    /**
     * @param array $factoriesMap
     * @return Instantiator
     */
    public function setFactoriesMap($factoriesMap)
    {
        $this->factoriesMap = $factoriesMap;
        return $this;
    }

    /**
     * @param string $className
     *
     * @return bool|mixed
     */
    public function findFactory($className)
    {
        if (array_key_exists($className, $this->factoriesMap)) {
            return $this->factoriesMap[$className];
        }
        return false;
    }

    /**
     * @param $className
     *
     * @return FactoryInterface
     *
     * @throws InstantiatorException
     */
    public function instantiate($className)
    {
        $factoryClassName = $this->findFactory($className);
        if (!$factoryClassName) {
            throw new InstantiatorException(sprintf("The factory %s you are trying to instantiate is not detected in factories config",
                $factoryClassName
            ));
        }
        if (!class_exists($factoryClassName)) {
            throw new DispatcherException(sprintf("Factory class %s was not found",
                $factoryClassName
            ));
        }
        $factory = new $factoryClassName($this);

        return $factory($this);
    }
}