<?php

namespace TodoList\Domain\WriteModel;

use Broadway\CommandHandling;
use Broadway\EventSourcing;
use Pimple\Container;

class TodoListCommandHandler extends CommandHandling\CommandHandler
{
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self($container['WriteModel\TodoList\TodoListRepository']);
    }

    private function __construct(EventSourcing\EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function handleStartCommand(TodoList\StartCommand $command)
    {
        $todoList = TodoList\TodoList::start($command->todoListId);

        $this->repository->add($todoList);
    }
}
