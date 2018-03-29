<?php

namespace Framework\Instantiator;

class Instantiator implements InstantiatorInterface
{
    private $factoriesMap = [];

    public function __construct()
    {
        $modulesConfig = require (ROOT . DS . 'config' . DS . 'modules.php');
        foreach ($modulesConfig as $namespace){
            $configPath = ROOT . DS . 'application' . DS . 'module' . DS . $namespace . DS . 'config' . DS . 'config.php';
            if (!is_file($configPath)) {
                throw new InstantiatorException("Config file not found $configPath");
            }
            $config = require ($configPath);
            if (!array_key_exists('factories', $config)) {
                continue;
            }
            if (is_array($config['factories'])) {
                $this->factoriesMap = array_merge($this->factoriesMap, $config['factories']);
            }
        }
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