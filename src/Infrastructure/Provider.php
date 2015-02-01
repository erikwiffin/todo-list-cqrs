<?php

namespace TodoList\Infrastructure;

use Broadway;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $eventDispatcher  = new Broadway\EventDispatcher\EventDispatcher();
        $simpleCommandBus = new Broadway\CommandHandling\SimpleCommandBus();

        $container['CommandBus'] = function ($c) use ($eventDispatcher, $simpleCommandBus) {
            return new Broadway\CommandHandling\EventDispatchingCommandBus($simpleCommandBus, $eventDispatcher);
        };

        $container['ReadModelRepository'] = function ($c) {
            return new Broadway\ReadModel\InMemory\InMemoryRepository();
        };

        $container['TodoListProjector'] = function ($c) {
            return new TodoListProjector($c['ReadModelRepository']);
        };
    }
}
