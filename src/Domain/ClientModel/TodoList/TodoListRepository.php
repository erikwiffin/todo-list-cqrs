<?php

namespace TodoList\Domain\ClientModel\TodoList;

use Broadway\ReadModel\RepositoryInterface;

interface TodoListRepository extends RepositoryInterface
{
    public function flush();
}
