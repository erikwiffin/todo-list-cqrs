<?php

namespace TodoList\Domain;

use Broadway;

class TodoListCommandHandler extends Broadway\CommandHandling\CommandHandler
{
    private $repository;

    public function __construct(Broadway\EventSourcing\EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function handleStartCommand(TodoList\StartCommand $command)
    {
        $todoList = TodoList\TodoList::start($command->todoListId);

        $this->repository->add($todoList);
    }
}
