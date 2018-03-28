<?php

namespace Main\Controller;

use Framework\Mvc\Controller\Controller;
use Main\Factory\EntityManagerFactory;

class BaseController extends Controller
{
    protected $entityManager;

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->init();
    }
}