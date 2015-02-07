<?php

namespace TodoList\Infrastructure;

use Broadway\CommandHandling;
use Broadway\EventDispatcher;
use Broadway\EventHandling;
use Broadway\EventStore;
use Broadway\ReadModel;
use Broadway\Serializer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TodoList\Domain\WriteModel;

class Provider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $eventDispatcher  = new EventDispatcher\EventDispatcher();
        $simpleCommandBus = new CommandHandling\SimpleCommandBus();

        $container['EntityManager'] = function ($container) {
            $config = Setup::createConfiguration(
                $container['config']['doctrine']['isDevMode'],
                $container['config']['doctrine']['proxyDir']
            );
            $driver = new SimplifiedYamlDriver(
                $container['config']['doctrine']['namespaces']
            );
            $config->setMetadataDriverImpl($driver);

            $em = EntityManager::create(
                $container['config']['db'],
                $config
            );

            // Register ENUMs
            $em->getConnection()
                ->getDatabasePlatform()
                ->registerDoctrineTypeMapping('enum', 'string');

            return $em;
        };

        $container['EventStore'] = function ($container) {
            $schemaManager = $container['EntityManager']
                ->getConnection()->getSchemaManager();
            $schema = $schemaManager->createSchema();
            $eventStore = new EventStore\DBALEventStore(
                $container['EntityManager']->getConnection(),
                new Serializer\SimpleInterfaceSerializer(),
                new Serializer\SimpleInterfaceSerializer(),
                'events'
            );

            $table = $eventStore->configureSchema($schema);
            if ($table) {
                $schemaManager->createTable($table);
            }

            return $eventStore;
        };

        $container['EventBus'] = function ($container) {
            return new EventHandling\SimpleEventBus();
        };

        $container['CommandBus'] = function ($c) use ($eventDispatcher, $simpleCommandBus) {
            return new CommandHandling\EventDispatchingCommandBus(
                $simpleCommandBus,
                $eventDispatcher
            );
        };

        $container['WriteModel\TodoList\TodoListRepository'] = function ($container) {
            return new WriteModel\TodoList\TodoListRepository(
                $container['EventStore'],
                $container['EventBus']
            );
        };

        $container['ReadModel\TodoList\TodoListRepository'] = function ($c) {
            return Persistence\Doctrine\TodoListRepository::fromContainer($c);
        };
    }
}
