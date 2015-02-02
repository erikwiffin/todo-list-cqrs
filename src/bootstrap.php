<?php

namespace TodoList;

use Pimple\Container;

$container = new Container();
$container['config'] = require 'config.php';
$container->register(new Infrastructure\Provider());
$container->register(new Domain\Provider());
$container->register(new Application\Provider());
$container->register(new Ui\Provider());

$container['App']->run();
