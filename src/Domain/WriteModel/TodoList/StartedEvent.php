<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Broadway\Serializer;

class StartedEvent
    extends TodoListEvent
    implements Serializer\SerializableInterface
{
    public static function deserialize(array $data)
    {
        return new self($data['todoListId']);
    }

    public function serialize()
    {
        return [
            'todoListId' => $this->todoListId,
        ];
    }
}