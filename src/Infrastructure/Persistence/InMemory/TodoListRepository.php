<?php

namespace TodoList\Infrastructure\Persistence\InMemory;

use Broadway\ReadModel;
use TodoList\Domain\ReadModel\TodoList;

class TodoListRepository
    extends ReadModel\InMemory\InMemoryRepository
    implements TodoList\TodoListRepository
{
}
