<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Broadway\Serializer;

class StartedEvent
    extends TodoListEvent
    implements Serializer\SerializableInterface
{
    public $title;

    public function __construct($id, $title)
    {
        parent::__construct($id);
        $this->title = $title;
    }

    public static function deserialize(array $data)
    {
        return new self($data['todoListId'], $data['title']);
    }

    public function serialize()
    {
        return [
            'todoListId' => $this->todoListId,
            'title' => $this->title,
        ];
    }
}
