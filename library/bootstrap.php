<?php

require (ROOT . DS . 'vendor' . DS . 'autoload.php');
$applicationFactory  = new \Framework\ApplicationFactory();
$applicationFactory->init()->start();
