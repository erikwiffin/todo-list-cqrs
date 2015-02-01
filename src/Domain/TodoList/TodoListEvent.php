<?php

namespace TodoList\Domain\TodoList;

abstract class TodoListEvent
{
    public $todoListId;

    public function __construct($todoListId)
    {
        $this->todoListId = $todoListId;
    }
}
