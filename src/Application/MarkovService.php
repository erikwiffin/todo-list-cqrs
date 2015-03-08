<?php

namespace TodoList\Application;

use Broadway\ClientModel\RepositoryInterface;
use Broadway\CommandHandling\CommandBusInterface;
use Broadway\Domain\DomainEventStream;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStoreInterface;
use Pimple\Container;
use Rhumsaa\Uuid\Uuid;
use TodoList\Domain\MarkovModel;
use TodoList\Infrastructure\Persistence\InMemory;

class MarkovService
{
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['MarkovModel\TransitionRepository']
        );
    }

    private function __construct(
        MarkovModel\TransitionRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function buildMarkovModel()
    {
        $transitions = $this->repository->findAll();

        $set = new MarkovModel\TransitionSet();
        foreach ($transitions as $transition) {
            $set->addTransition($transition);
        }

        $map = [];
        foreach ($set->states() as $state) {
            $map[$this->clean($state->name())] = array_reduce(
                $set->transitionsFor($state),
                function ($carry, $item) {
                    $item = $this->clean($item);
                    if (empty($carry[$item])) {
                        $carry[$item] = 0;
                    }

                    $carry[$item]++;

                    return $carry;
                },
                []
            );
        }

        return $map;
    }

    private function clean($state)
    {
        $classParts = explode('\\', $state);

        return end($classParts);
    }
}
