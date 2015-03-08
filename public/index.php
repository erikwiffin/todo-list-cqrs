<?php

use Pimple\Container;
use TodoList;

chdir(__DIR__.'/..');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

$container = new Container();
$container->register(new TodoList\Provider());

$container['App']->run();
