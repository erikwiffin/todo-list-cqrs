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
            $container['ReadModel\TodoList\TodoListRepository']
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
        $id = Uuid::uuid4()->toString();
        $command = new Domain\WriteModel\TodoList\StartCommand($id);

        $this->commandBus->dispatch($command);
        $this->repository->flush();

        return $id;
    }

    public function displayTodoList($id)
    {
        return $this->repository->find($id);
    }

    public function addTask($id, $task)
    {
        $command = new Domain\WriteModel\TodoList\AddTaskCommand($id, $task);

        $this->commandBus->dispatch($command);
        $this->repository->flush();
    }
}
