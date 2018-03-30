<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('PUBLIC_PATH', ROOT . DS . 'public');

require (ROOT . DS . 'library' . DS . 'src' . DS . 'Autoloader' . DS . 'NamespaceAutoloader.php');
require (ROOT . DS . 'vendor' . DS . 'autoload.php');

$autoloader = new NamespaceAutoloader();
$autoloader->register();