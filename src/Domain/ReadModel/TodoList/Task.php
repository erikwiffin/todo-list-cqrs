<?php

namespace TodoList\Domain\ReadModel\TodoList;

class Task
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_COMPLETED = 'COMPLETED';

    private $id;
    private $description;
    private $status;

    public static function fromDescription($description)
    {
        return new self($description, self::STATUS_ACTIVE);
    }

    private function __construct($description, $status)
    {
        $this->description = $description;
        $this->status = $status;
    }

    public function equals($task)
    {
        return $this->description == $task;
    }

    public function complete()
    {
        return new self($this->description, self::STATUS_COMPLETED);
    }

    public function description()
    {
        return $this->description;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isCompleted()
    {
        return $this->status == self::STATUS_COMPLETED;
    }
}
