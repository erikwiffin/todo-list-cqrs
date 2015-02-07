<?php

namespace TodoList\Domain\WriteModel\TodoList;

class Task
{
    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_COMPLETED = "COMPLETED";

    protected $description;
    protected $status;

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

    public function isComplete()
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    public function complete()
    {
        return new self($this->description, self::STATUS_COMPLETED);
    }
}
