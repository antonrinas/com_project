<?php

namespace Main\Factory;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class EntityManagerFactory implements EntityManagerFactoryInterface
{
    /**
     * @return EntityManagerInterface
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function init()
    {
        $paths = [ROOT . DS . 'application' . DS . 'module' . DS . 'Model' . DS . 'src' . DS . 'Entity'];
        $isDevMode = false;
        $dbParams = require_once (ROOT . DS . 'config' . DS . 'db_doctrine.php');

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        return EntityManager::create($dbParams, $config);
    }
}