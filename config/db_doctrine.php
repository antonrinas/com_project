<?php

return [
    'driver'   => 'pdo_mysql',
    'user'     => 'admin',
    'password' => 'admin',
    'dbname'   => 'com_project',
    'host'     => 'localhost',
    'charset'  => 'utf8',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]
];