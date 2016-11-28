<?php

require_once "vendor/autoload.php";

use Symfony\Component\Console\Application;
use Symfony\Component\Debug\Debug;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

Debug::enable();



$paths = [__DIR__."/src/Todo/Database"];

$dbParams = [
    'driver'    => 'pdo_mysql',
    'user'      => 'root',
    'password'  => 'root',
    'dbname'    => 'todo',
];
$config = Setup::createAnnotationMetadataConfiguration($paths);
$entityManager = EntityManager::create($dbParams, $config);

$application = new Application("Todo App");
$application->add(new \Todo\Command\AddCommand($entityManager));
$application->add(new \Todo\Command\ShowCommand($entityManager));
$application->setDefaultCommand('show');

$application->run();