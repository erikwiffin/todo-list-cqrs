<?php

namespace TodoList\Domain;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['EventBus']
            ->subscribe(ClientModel\TodoListProjector::fromContainer($container));

        $container['EventBus']
            ->subscribe(MarkovModel\TransitionProjector::fromContainer($container));

        $container['CommandBus']
            ->subscribe(WriteModel\TodoListCommandHandler::fromContainer($container));
    }
}
