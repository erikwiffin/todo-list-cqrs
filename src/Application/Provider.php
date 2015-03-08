<?php

namespace TodoList\Application;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['TodoList\Application\AdminService'] = function ($c) {
            return AdminService::fromContainer($c);
        };

        $container['TodoList\Application\MarkovService'] = function ($c) {
            return MarkovService::fromContainer($c);
        };

        $container['TodoList\Application\TodoListService'] = function ($c) {
            return TodoListService::fromContainer($c);
        };
    }
}
