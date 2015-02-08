<?php

namespace TodoList\Ui\Controller;

use Pimple\Container;
use Slim\Slim;
use TodoList\Application;

class AdminController
{
    private $app;
    private $service;

    private function __construct(
        Slim $app,
        Application\AdminService $service
    ) {
        $this->app = $app;
        $this->service = $service;
    }

    public static function fromContainer(Container $container)
    {
        return new self(
            $container['App'],
            $container['TodoList\Application\AdminService']
        );
    }

    public function index()
    {
        $this->service->displayDomainEventLog();
        $this->app->render('admin/index.twig');
    }
}
