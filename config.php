<?php

return [
    'db' => [
        'path' => 'database/todolist.db',
        'driver' => 'pdo_sqlite',
        'charset' => 'utf8',
    ],
    'doctrine' => [
        'paths' => 'src/Infrastructure/Mapping',
        'isDevMode' => true,
        'proxyDir' => 'data/DoctrineORMModule/Proxy',
        'namespaces' => [
            'src/Infrastructure/Mapping/' => 'TodoList\Domain\ClientModel',
        ],
    ],
    'slim' => [
        'debug' => true,
        'view' => new Slim\Views\Twig(),
        'templates.path' => 'src/Ui/Templates',
    ],
];
