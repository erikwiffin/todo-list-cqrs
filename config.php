<?php

return [
    'db' => [
        'dbname' => 'todolist',
        'user' => 'todolist',
        'password' => 'QT3w96abj7FCpfZa',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ],
    'doctrine' => [
        'paths' => 'src/Infrastructure/Mapping',
        'isDevMode' => true,
        'proxyDir' => 'data/DoctrineORMModule/Proxy',
        'namespaces' => [
            'src/Infrastructure/Mapping/' => 'TodoList\Domain\ReadModel',
        ],
    ],
    'slim' => [
        'debug' => true,
        'view' => new Slim\Views\Twig(),
        'templates.path' => 'src/Ui/Templates',
    ],
];
