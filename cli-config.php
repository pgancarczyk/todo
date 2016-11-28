<?php
// cli-config.php
require_once "todo.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);