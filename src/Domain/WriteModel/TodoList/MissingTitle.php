<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Exception;

class MissingTitle extends Exception
{
    public function __construct()
    {
        parent::__construct("A title is required.");
    }
}
