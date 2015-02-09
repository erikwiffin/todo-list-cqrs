<?php

namespace TodoList\Infrastructure\Persistence\InMemory;

use Broadway\ReadModel;
use TodoList\Domain\ClientModel\TodoList;

class TodoListRepository
    extends ReadModel\InMemory\InMemoryRepository
    implements TodoList\TodoListRepository
{
    public function flush()
    {
        // no-op
    }
}
