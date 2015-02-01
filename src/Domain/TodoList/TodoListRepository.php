<?php

namespace TodoList\Domain\TodoList;

use Broadway;

class TodoListRepository extends Broadway\EventSourcing\EventSourcingRepository
{
    public function __construct(Broadway\EventStore\EventStoreInterface $eventStore, Broadway\EventHandling\EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, 'TodoList\Domain\TodoList\TodoList', new Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory());
    }
}
