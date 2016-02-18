<?php
//bootstrap.php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Models'), $isDevMode);
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'myocr',
    'password' => 'myocrtest',
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'MyOCR',
);


$entityManager = EntityManager::create($conn, $config);
?>