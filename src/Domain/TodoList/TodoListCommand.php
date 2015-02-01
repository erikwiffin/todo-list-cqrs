<?php

namespace TodoList\Domain\TodoList;

abstract class TodoListCommand
{
    public $todoListId;

    public function __construct($todoListId)
    {
        $this->todoListId = $todoListId;
    }
}
