<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Broadway\EventSourcing;

class TodoList extends EventSourcing\EventSourcedAggregateRoot
{
    private $todoListId;
    private $tasks = [];

    public static function start($todoListId)
    {
        $todoList = new self();

        // After instantiation of the object we apply the "StartedEvent".
        $todoList->apply(new StartedEvent($todoListId));

        return $todoList;
    }

    public static function instantiateForReconstitution()
    {
        return new self();
    }

    public function addTask($task)
    {
        $this->apply(new TaskWasAddedEvent($this->todoListId, $task));
    }

    private function __construct()
    {
    }

    public function getAggregateRootId()
    {
        return $this->todoListId;
    }

    protected function applyStartedEvent(StartedEvent $event)
    {
        $this->todoListId = $event->todoListId;
    }

    protected function applyTaskWasAddedEvent(TaskWasAddedEvent $event)
    {
        $this->tasks[] = new Task($event->task);
    }
}
