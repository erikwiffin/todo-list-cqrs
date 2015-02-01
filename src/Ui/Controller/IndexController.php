<?php

namespace TodoList\Ui\Controller;

use Pimple\Container;
use Slim\Slim;
use TodoList\Application;

class IndexController
{
    private $app;
    private $service;

    private function __construct(
        Slim $app,
        Application\TodoListService $service
    ) {
        $this->app = $app;
        $this->service = $service;
    }

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['App'],
            $container['TodoList\Application\TodoListService']
        );
    }

    public function index()
    {
        $list = $this->service->startPlanning();

        $this->app->render('index.twig', compact('list'));
    }
}
