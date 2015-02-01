<?php

namespace TodoList\Ui;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['TodoList\Ui\Controller\IndexController'] = function ($c) {
            return Controller\IndexController::fromContainer($c);
        };
    }
}
