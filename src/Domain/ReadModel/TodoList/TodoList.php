<?php

namespace TodoList\Domain\ReadModel\TodoList;

use Broadway\ReadModel\ReadModelInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TodoList implements ReadModelInterface
{
    private $id;
    private $uuid;
    private $tasks;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->tasks = new ArrayCollection([]);
    }

    public function getId()
    {
        return $this->uuid;
    }

    public function addTask($task)
    {
        $this->tasks->add(new Task($task));
    }

    public function tasks()
    {
        return $this->tasks->getValues();
    }
}
