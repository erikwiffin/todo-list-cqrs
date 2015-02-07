<?php

namespace TodoList\Domain\WriteModel\TodoList;

class StartCommand extends TodoListCommand
{
    public $title;

    public function __construct($id, $title)
    {
        parent::__construct($id);
        $this->title = $title;
    }
}
