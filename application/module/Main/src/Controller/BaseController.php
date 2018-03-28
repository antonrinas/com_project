<?php

namespace Main\Controller;

use Framework\Mvc\Controller\Controller;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class BaseController extends Controller
{
    protected $entityManager;

    public function __construct()
    {
        $paths = [ROOT . DS . 'application' . DS . 'module' . DS . 'Model' . DS . 'src' . DS . 'Entity'];
        $isDevMode = false;
        $dbParams = require_once (ROOT . DS . 'config' . DS . 'db_doctrine.php');
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }
}