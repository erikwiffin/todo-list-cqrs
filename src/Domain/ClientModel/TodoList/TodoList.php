<?php

namespace TodoList\Domain\ClientModel\TodoList;

use Broadway\ReadModel\ReadModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use TodoList\Domain\WriteModel;

class TodoList implements ReadModelInterface
{
    private $id;
    private $uuid;
    private $tasks;
    private $title;

    public static function fromStartedEvent(WriteModel\TodoList\StartedEvent $event)
    {
        return new self($event->todoListId, $event->title);
    }

    private function __construct($uuid, $title)
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->tasks = new ArrayCollection([]);
    }

    public function getId()
    {
        return $this->uuid;
    }

    public function addTask($task)
    {
        $this->tasks->add(Task::fromDescription($task));
    }

    public function completeTask($task)
    {
        $oldTask = $this->tasks->get($task);
        $this->tasks->remove($task);
        $this->tasks->set($task, $oldTask->complete());
    }

    public function removeTask($task)
    {
        $this->tasks->remove($task);
    }

    public function tasks()
    {
        return $this->tasks->getValues();
    }

    public function title()
    {
        return $this->title;
    }
}
