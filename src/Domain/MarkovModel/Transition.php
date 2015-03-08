<?php

namespace TodoList\Domain\MarkovModel;

use Broadway\ReadModel\ReadModelInterface;

class Transition implements ReadModelInterface
{
    private $id;
    private $prevState;
    private $nextState;

    public static function create(State $prevState = null, State $nextState)
    {
        return new self($prevState, $nextState);
    }

    private function __construct(State $prevState = null, State $nextState)
    {
        $this->prevState = $prevState;
        $this->nextState = $nextState;
    }

    public function getId()
    {
        return $id;
    }

    public function prevState()
    {
        return $this->prevState;
    }

    public function nextState()
    {
        return $this->nextState;
    }
}
