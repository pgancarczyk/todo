<?php

require "vendor/autoload.php";

use Symfony\Component\Console\Application;

$application = new Application("Todo App");
$application->add(new \Todo\Command\ListCommand);
$application->run();