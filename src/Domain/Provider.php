<?php

namespace TodoList\Domain;

use Broadway\EventStore\InMemoryEventStore;
use Broadway\EventHandling\SimpleEventBus;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['EventStore'] = function ($container) {
            return new InMemoryEventStore();
        };

        $container['EventBus'] = function ($container) {
            return new SimpleEventBus();
        };

        $container['EventBus']->subscribe($container['TodoListProjector']);

        $repository = new TodoList\TodoListRepository(
            $container['EventStore'],
            $container['EventBus']
        );
        $commandHandler = new TodoListCommandHandler($repository);

        $container['CommandBus']->subscribe($commandHandler);
    }
}
