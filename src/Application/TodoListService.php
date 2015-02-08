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
            $container['ClientModel\TodoList\TodoListRepository']
        );
    }

    private function __construct(
        CommandBusInterface $commandBus,
        RepositoryInterface $repository
    ) {
        $this->commandBus = $commandBus;
        $this->repository = $repository;
    }

    public function startPlanning($title)
    {
        $id = Uuid::uuid4()->toString();
        $command = new Domain\WriteModel\TodoList\StartCommand($id, $title);

        $this->commandBus->dispatch($command);

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
    }

    public function completeTask($id, $task)
    {
        $command = new Domain\WriteModel\TodoList\CompleteTaskCommand($id, $task);

        $this->commandBus->dispatch($command);
    }

    public function removeTask($id, $task)
    {
        $command = new Domain\WriteModel\TodoList\RemoveTaskCommand($id, $task);

        $this->commandBus->dispatch($command);
    }
}
