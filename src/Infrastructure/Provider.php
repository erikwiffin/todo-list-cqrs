<?php

namespace TodoList\Infrastructure;

use Broadway\CommandHandling;
use Broadway\EventDispatcher;
use Broadway\EventHandling;
use Broadway\EventStore;
use Broadway\ReadModel;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TodoList\Domain\WriteModel;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $eventDispatcher  = new EventDispatcher\EventDispatcher();
        $simpleCommandBus = new CommandHandling\SimpleCommandBus();

        $container['EventStore'] = function ($container) {
            return new EventStore\InMemoryEventStore();
        };

        $container['EventBus'] = function ($container) {
            return new EventHandling\SimpleEventBus();
        };

        $container['CommandBus'] = function ($c) use ($eventDispatcher, $simpleCommandBus) {
            return new CommandHandling\EventDispatchingCommandBus(
                $simpleCommandBus,
                $eventDispatcher
            );
        };

        $container['WriteModel\TodoList\TodoListRepository'] = function ($container) {
            return new WriteModel\TodoList\TodoListRepository(
                $container['EventStore'],
                $container['EventBus']
            );
        };

        $container['ReadModel\TodoList\TodoListRepository'] = function ($c) {
            return new Persistence\InMemory\TodoListRepository();
        };
    }
}
