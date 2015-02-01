<?php

namespace TodoList\Application;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['TodoList\Application\TodoListService'] = function ($c) {
            return TodoListService::fromContainer($c);
        };
    }
}
