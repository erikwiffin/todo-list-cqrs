<?php

namespace TodoList\Domain\ReadModel\TodoList;

use Broadway\ReadModel\ReadModelInterface;

class TodoList implements ReadModelInterface
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
