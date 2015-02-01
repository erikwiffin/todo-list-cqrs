<?php

namespace TodoList\Domain\TodoList;

use Broadway;

class TodoList extends Broadway\EventSourcing\EventSourcedAggregateRoot
{
    private $todoListId;

    public static function start($todoListId)
    {
        $todoList = new TodoList();

        // After instantiation of the object we apply the "StartedEvent".
        $todoList->apply(new StartedEvent($todoListId));

        return $todoList;
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
}
