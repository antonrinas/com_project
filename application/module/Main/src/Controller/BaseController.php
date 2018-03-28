<?php

namespace Main\Controller;

use Framework\Mvc\Controller\Controller;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class BaseController extends Controller
{
    protected $entityManager;

    public function __construct()
    {
        $paths = [ROOT . DS . 'application' . DS . 'module' . DS . 'Model' . DS . 'src' . DS . 'Entity'];
        $isDevMode = false;
        $dbParams = require_once (ROOT . DS . 'config' . DS . 'db_doctrine.php');

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }
}