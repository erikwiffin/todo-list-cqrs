<?php

namespace TodoList\Application;

use Broadway\ClientModel\RepositoryInterface;
use Broadway\CommandHandling\CommandBusInterface;
use Broadway\Domain\DomainEventStream;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStoreInterface;
use Pimple\Container;
use Rhumsaa\Uuid\Uuid;
use TodoList\Domain\ClientModel;
use TodoList\Infrastructure\Persistence\InMemory;

class AdminService
{
    private $commandBus;
    private $eventStore;
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['CommandBus'],
            $container['ClientModel\TodoList\TodoListRepository'],
            $container['EventStore']
        );
    }

    private function __construct(
        CommandBusInterface $commandBus,
        ClientModel\TodoList\TodoListRepository $repository,
        EventStoreInterface $eventStore
    ) {
        $this->commandBus = $commandBus;
        $this->repository = $repository;
        $this->eventStore = $eventStore;
    }

    public function displayTodoLists()
    {
        return $this->repository->findAll();
    }

    public function displayDomainEventLog($id)
    {
        return $this->eventStore->load($id);
    }

    public function displayTodoListAtPlayhead($id, $playhead)
    {
        $repository = new InMemory\TodoListRepository();
        $projector = ClientModel\TodoListProjector::withRepository($repository);

        $eventBus = new SimpleEventBus();
        $eventBus->subscribe($projector);

        $events = $this->eventStore->load($id);

        $slice = [];
        foreach ($events as $event) {
            if ($event->getPlayhead() <= $playhead) {
                $slice[] = $event;
            }
        }

        $snapshot = new DomainEventStream($slice);
        $eventBus->publish($snapshot);

        return $repository->find($id);
    }
}
