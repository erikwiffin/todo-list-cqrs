<?php

namespace TodoList\Domain\WriteModel\TodoList;

abstract class TodoListEvent
{
    public $todoListId;

    public function __construct($todoListId)
    {
        $this->todoListId = $todoListId;
    }
}
