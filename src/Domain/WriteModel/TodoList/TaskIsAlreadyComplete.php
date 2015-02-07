<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Exception;

class TaskIsAlreadyComplete extends Exception
{
    public function __construct($task)
    {
        $message = sprintf('Task "%s" is already complete.', $task);
        parent::__construct($message);
    }
}
