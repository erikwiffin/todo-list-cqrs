<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Broadway\EventSourcing;

class TodoList extends EventSourcing\EventSourcedAggregateRoot
{
    private $todoListId;
    private $tasks = [];
    private $title;

    public static function start($todoListId, $title)
    {
        $todoList = new self();
        $todoList->validateTitle($title);

        // After instantiation of the object we apply the "StartedEvent".
        $todoList->apply(new StartedEvent($todoListId, $title));

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

    public function completeTask($task)
    {
        $this->guardTaskExists($task);
        $this->guardTaskIsNotAlreadyComplete($task);
        $this->apply(new TaskWasCompletedEvent($this->todoListId, $task));
    }

    public function removeTask($task)
    {
        $this->guardTaskExists($task);
        $this->apply(new TaskWasRemovedEvent($this->todoListId, $task));
    }

    private function __construct()
    {
    }

    public function getAggregateRootId()
    {
        return $this->todoListId;
    }

    protected static function validateTitle($title)
    {
        if (empty($title)) {
            throw new MissingTitle;
        }
    }

    protected function guardTaskExists($task)
    {
        if (!isset($this->tasks[$task])) {
            throw new MissingTask($task);
        }
    }

    protected function guardTaskIsNotAlreadyComplete($task)
    {
        if ($this->tasks[$task]->isComplete()) {
            throw new TaskIsAlreadyComplete($task);
        }
    }

    protected function applyStartedEvent(StartedEvent $event)
    {
        $this->todoListId = $event->todoListId;
        $this->title = $event->title;
    }

    protected function applyTaskWasAddedEvent(TaskWasAddedEvent $event)
    {
        $this->tasks[] = Task::fromDescription($event->task);
    }

    protected function applyTaskWasCompletedEvent(TaskWasCompletedEvent $event)
    {
        $this->tasks[$event->task] = $this->tasks[$event->task]->complete();
    }

    protected function applyTaskWasRemovedEvent(TaskWasRemovedEvent $event)
    {
        array_splice($this->tasks, $event->task, 1);
    }
}
