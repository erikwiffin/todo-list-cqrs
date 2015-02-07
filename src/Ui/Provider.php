<?php

namespace TodoList\Ui;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['TodoList\Ui\Controller\IndexController'] = function ($c) {
            return Controller\IndexController::fromContainer($c);
        };

        $container['App'] = function ($container) {
            return new Slim\Slim($container['config']['slim']);
        };

        $container['App']->get('/', function () use ($container) {
            $container['TodoList\Ui\Controller\IndexController']->index();
        });

        $container['App']->get('/list/:id', function ($id) use ($container) {
            $container['TodoList\Ui\Controller\IndexController']->view($id);
        });

        $container['App']->post('/start-planning', function () use ($container) {
            $container['TodoList\Ui\Controller\IndexController']->startPlanning();
        });

        $container['App']->post('/list/add-task', function () use ($container) {
            $container['TodoList\Ui\Controller\IndexController']->addTask();
        });

        $container['App']->post('/list/complete-task', function () use ($container) {
            $container['TodoList\Ui\Controller\IndexController']->completeTask();
        });

        $container['App']->post('/list/remove-task', function () use ($container) {
            $container['TodoList\Ui\Controller\IndexController']->removeTask();
        });
    }
}
