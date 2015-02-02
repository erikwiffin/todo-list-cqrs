<?php

namespace TodoList\Infrastructure\Persistence\Doctrine;

use Broadway\ReadModel;
use Doctrine\Common\Persistence\ObjectManager;
use Pimple\Container;
use TodoList\Domain\ReadModel\TodoList;

class TodoListRepository
    implements TodoList\TodoListRepository
{
    private $objectManager;
    private $objectRepository;

    private function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->objectRepository = $objectManager->getRepository(
            'TodoList\Domain\ReadModel\TodoList\TodoList'
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
        return $this->objectRepository->findOneByUuid($id);
    }

    public function findBy(array $fields)
    {
        throw new \Exception('findBy');
    }

    public function findAll()
    {
        throw new \Exception('findAll');
    }

    public function remove($id)
    {
        throw new \Exception('remove');
    }
}
