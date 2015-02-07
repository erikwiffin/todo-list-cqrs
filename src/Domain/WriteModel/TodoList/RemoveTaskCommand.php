<?php

namespace TodoList\Domain\WriteModel\TodoList;

class RemoveTaskCommand extends TodoListCommand
{
    public $task;

    public function __construct($id, $task)
    {
        parent::__construct($id);
        $this->task = $task;
    }
}
