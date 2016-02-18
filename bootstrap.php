<?php
//bootstrap.php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Models'), $isDevMode);
$conn = array(
    'driver' => 'pdo_pgsql',
    'user' => 'MyOCR',
    'password' => 'MyOCR_user',
    'host' => '127.0.0.1',
    'port' => 5432,
    'dbname' => 'MyOCR',
    'schema' => 'public',
);


$entityManager = EntityManager::create($conn, $config);
?>