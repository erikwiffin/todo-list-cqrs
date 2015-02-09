<?php

namespace TodoList\Domain\ClientModel;

use Broadway\Domain\DomainMessage;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\RepositoryInterface;
use Pimple\Container;

class TodoListProjector extends Projector
{
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self($container['ClientModel\TodoList\TodoListRepository']);
    }

    public static function withRepository(RepositoryInterface $repository)
    {
        return new self($repository);
    }

    private function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function applyStartedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = TodoList\TodoList::fromStartedEvent($event);
        $this->repository->save($todoList);
        $this->repository->flush();
    }

    public function applyTaskWasAddedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = $this->repository->find($event->todoListId);
        $todoList->addTask($event->task);
        $this->repository->flush();
    }

    public function applyTaskWasCompletedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = $this->repository->find($event->todoListId);
        $todoList->completeTask($event->task);
        $this->repository->flush();
    }

    public function applyTaskWasRemovedEvent($event, DomainMessage $domainMessage)
    {
        $todoList = $this->repository->find($event->todoListId);
        $todoList->removeTask($event->task);
        $this->repository->flush();
    }
}
