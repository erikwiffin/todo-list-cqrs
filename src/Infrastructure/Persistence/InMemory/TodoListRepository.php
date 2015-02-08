<?php

namespace TodoList\Infrastructure\Persistence\InMemory;

use Broadway\ClientModel;
use TodoList\Domain\ClientModel\TodoList;

class TodoListRepository
    extends ClientModel\InMemory\InMemoryRepository
    implements TodoList\TodoListRepository
{
}
