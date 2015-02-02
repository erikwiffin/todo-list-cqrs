<?php

namespace TodoList\Domain\EventHandler;

use Broadway\Domain\DomainMessage;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\RepositoryInterface;
use Pimple\Container;
use TodoList\Domain\ReadModel\TodoList;

class TodoListProjector extends Projector
{
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self($container['ReadModel\TodoList\TodoListRepository']);
    }

    private function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function applyStartedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = new TodoList\TodoList($event->todoListId);
        $this->repository->save($todoList);
    }

    public function applyTaskWasAddedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = $this->repository->find($event->todoListId);
        $todoList->addTask($event->task);
    }
}
