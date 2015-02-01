<?php

namespace TodoList\Application;

use Broadway\CommandHandling\CommandBusInterface;
use Broadway\ReadModel\RepositoryInterface;
use Pimple\Container;
use Rhumsaa\Uuid\Uuid;
use TodoList\Domain;

class TodoListService
{
    private $commandBus;
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['CommandBus'],
            $container['ReadModelRepository']
        );
    }

    private function __construct(
        CommandBusInterface $commandBus,
        RepositoryInterface $repository
    ) {
        $this->commandBus = $commandBus;
        $this->repository = $repository;
    }

    public function startPlanning()
    {
        $id = Uuid::uuid4();
        $command = new Domain\TodoList\StartCommand($id);

        $this->commandBus->dispatch($command);

        return $this->repository->find($id);
    }
}
