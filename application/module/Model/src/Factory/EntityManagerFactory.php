<?php

namespace Model\Factory;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Instantiator\FactoryInterface;


class EntityManagerFactory implements FactoryInterface
{
    /**
     * @var mixed
     */
    private $object;

    public function __construct(InstantiatorInterface $instantiator)
    {
        $paths = [ROOT . DS . 'application' . DS . 'module' . DS . 'Model' . DS . 'src' . DS . 'Entity'];
        $isDevMode = false;
        $dbParams = require_once(ROOT . DS . 'config' . DS . 'db_doctrine.php');

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $this->object = EntityManager::create($dbParams, $config);
    }

    public function make()
    {
        return $this->object;
    }
}