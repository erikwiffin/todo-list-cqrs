<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Exception;

class MissingTask extends Exception
{
    public function __construct($task)
    {
        $message = sprintf('Task "%s" does not exist.', $task);
        parent::__construct($message);
    }
}
