<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Broadway\Serializer;

class TaskWasCompletedEvent
    extends TodoListEvent
    implements Serializer\SerializableInterface
{
    public $task;

    public function __construct($id, $task)
    {
        parent::__construct($id);
        $this->task = $task;
    }

    public static function deserialize(array $data)
    {
        return new self($data['todoListId'], $data['task']);
    }

    public function serialize()
    {
        return [
            'todoListId' => $this->todoListId,
            'task' => $this->task,
        ];
    }
}
