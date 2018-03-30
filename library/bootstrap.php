<?php

require (__DIR__ . '/src/Autoloader/NamespaceAutoloader.php');
require (ROOT . DS . 'vendor' . DS . 'autoload.php');

$autoloader = new NamespaceAutoloader();
$autoloader->register();

$applicationFactory  = new \Framework\ApplicationFactory();
$applicationFactory->init()->start();
