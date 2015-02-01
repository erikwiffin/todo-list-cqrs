<?php

namespace TodoList\Infrastructure;

use Broadway\Domain\DomainMessage;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\RepositoryInterface;

class TodoListProjector extends Projector
{
    private $repository;

    public function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function applyStartedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = new TodoList($event->todoListId);
        $this->repository->save($todoList);
    }
}
