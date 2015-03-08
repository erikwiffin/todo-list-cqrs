<?php

namespace TodoList\Domain\MarkovModel;

class TransitionSet
{
    private $transitions;

    public function addTransition(Transition $transition)
    {
        $prevState = $transition->prevState();
        $nextState = $transition->nextState();

        // We can ignore starting nodes
        if (empty($prevState)) {
            return;
        }

        $this->guardStateExists($prevState);

        $this->transitions[$prevState->name()][] = $nextState->name();
    }

    public function transitionsFor(State $state)
    {
        $this->guardStateExists($state);

        return $this->transitions[$state->name()];
    }

    public function states()
    {
        $states = array_keys($this->transitions);

        return array_map(function ($state) {
            return State::fromName($state);
        }, $states);
    }

    private function guardStateExists(State $state)
    {
        $stateName = $state->name();

        if (!isset($this->transitions[$stateName])) {
            $this->transitions[$stateName] = [];
        }
    }
}
