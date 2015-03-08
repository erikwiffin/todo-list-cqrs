<?php

namespace TodoList\Domain\MarkovModel;

use Broadway\Domain\DomainMessage;
use Broadway\EventStore\EventStoreInterface;
use Broadway\ReadModel\ProjectorInterface;
use Broadway\ReadModel\RepositoryInterface;
use Pimple\Container;

class TransitionProjector implements ProjectorInterface
{
    private $eventStore;
    private $repository;

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['EventStore'],
            $container['MarkovModel\TransitionRepository']
        );
    }

    private function __construct(
        EventStoreInterface $eventStore,
        RepositoryInterface $repository
    ) {
        $this->eventStore = $eventStore;
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(DomainMessage $domainMessage)
    {
        $prevState = $this->getPreviousState($domainMessage);
        $nextState = State::fromDomainMessage($domainMessage);

        $transition = Transition::create($prevState, $nextState);

        $this->repository->save($transition);
        $this->repository->flush();
    }

    private function getPreviousState(DomainMessage $domainMessage)
    {
        $id = $domainMessage->getId();
        $playhead = $domainMessage->getPlayhead();

        $events = $this->eventStore->load($id);

        foreach ($events as $event) {
            if ((int) $event->getPlayhead() === ($playhead - 1)) {
                return State::fromDomainMessage($event);
            }
        }

        return null;
    }
}
