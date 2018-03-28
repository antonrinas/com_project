<?php

namespace Main\Controller;

use Framework\Mvc\Controller\Controller;
use Main\Factory\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

class BaseController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->init();
    }
}