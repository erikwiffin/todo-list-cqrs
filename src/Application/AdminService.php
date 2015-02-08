<?php

namespace TodoList\Application;

use Broadway\CommandHandling\CommandBusInterface;
use Broadway\ClientModel\RepositoryInterface;
use Pimple\Container;
use Rhumsaa\Uuid\Uuid;
use TodoList\Domain;

class AdminService
{
    private $commandBus;
    private $container;

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['CommandBus'],
            $container
        );
    }

    private function __construct(
        CommandBusInterface $commandBus,
        $container
    ) {
        $this->commandBus = $commandBus;
        $this->container = $container;
    }

    public function displayDomainEventLog()
    {
        $eventStore = $this->container['EventStore'];
        $events = $eventStore->load('aaede3e1-f40a-4278-9098-5e5dd4f4aef3');

        foreach ($events as $event) {
            var_dump($event);
        }
    }
}
