<?php

namespace TodoList\Infrastructure\Persistence\Doctrine;

use Broadway\ReadModel;
use Doctrine\Common\Persistence\ObjectManager;
use Pimple\Container;
use TodoList\Domain\MarkovModel;

class TransitionRepository
    implements MarkovModel\TransitionRepository
{
    private $objectManager;
    private $objectRepository;

    private function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->objectRepository = $objectManager->getRepository(
            'TodoList\Domain\MarkovModel\Transition'
        );
    }

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['EntityManager']
        );
    }

    public function flush()
    {
        $this->objectManager->flush();
    }

    public function save(ReadModel\ReadModelInterface $data)
    {
        $this->objectManager->persist($data);
    }

    public function find($id)
    {
        throw new \Exception('find');
    }

    public function findBy(array $fields)
    {
        throw new \Exception('findBy');
    }

    public function findAll()
    {
        return $this->objectRepository->findBy([]);
    }

    public function remove($id)
    {
        throw new \Exception('remove');
    }
}
