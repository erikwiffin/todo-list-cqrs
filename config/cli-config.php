<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Pimple\Container;
use TodoList\Infrastructure;

chdir(__DIR__.'/..');

require 'vendor/autoload.php';

$container = new Container();
$container->register(new TodoList\Provider());

$entityManager = $container['EntityManager'];

return ConsoleRunner::createHelperSet($entityManager);
