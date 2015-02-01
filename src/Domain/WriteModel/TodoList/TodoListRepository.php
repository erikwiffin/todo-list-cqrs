<?php

namespace TodoList\Domain\WriteModel\TodoList;

use Broadway\EventHandling;
use Broadway\EventSourcing;
use Broadway\EventStore;

class TodoListRepository extends EventSourcing\EventSourcingRepository
{
    public function __construct(
        EventStore\EventStoreInterface $eventStore,
        EventHandling\EventBusInterface $eventBus
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            'TodoList\Domain\WriteModel\TodoList\TodoList',
            new EventSourcing\AggregateFactory\PublicConstructorAggregateFactory()
        );
    }
}
