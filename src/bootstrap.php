<?php

namespace TodoList;

use Phalcon;
use Pimple\Container;
use Slim;

$container = new Container();
$container->register(new Infrastructure\Provider());
$container->register(new Domain\Provider());
$container->register(new Application\Provider());
$container->register(new Ui\Provider());

$container['App'] = function ($container) {
    $app = new Slim\Slim([
        'debug' => true,
        'view' => new Slim\Views\Twig(),
        'templates.path' => 'src/Ui/Templates',
    ]);

    return $app;
};

$container['App']->get('/', function () use ($container) {
    $container['TodoList\Ui\Controller\IndexController']->index();
});

$container['App']->run();
