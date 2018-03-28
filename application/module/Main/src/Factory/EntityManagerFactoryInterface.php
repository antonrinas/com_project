<?php

namespace Main\Factory;

use Doctrine\ORM\EntityManagerInterface;

interface EntityManagerFactoryInterface
{
    /**
     * @return EntityManagerInterface
     */
    public function init();
}