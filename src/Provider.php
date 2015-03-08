<?php

namespace TodoList;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['config'] = require 'config/config.php';

        $container->register(new Infrastructure\Provider());
        $container->register(new Domain\Provider());
        $container->register(new Application\Provider());
        $container->register(new Ui\Provider());
    }
}
