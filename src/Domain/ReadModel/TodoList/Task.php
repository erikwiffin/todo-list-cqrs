<?php

namespace TodoList\Domain\ReadModel\TodoList;

class Task
{
    private $id;
    private $description;

    public function __construct($description)
    {
        $this->description = $description;
    }

    public function description()
    {
        return $this->description;
    }
}
