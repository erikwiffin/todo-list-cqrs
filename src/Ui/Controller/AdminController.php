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

        $this->app->view->parserExtensions = [
            new \Twig_Extension_Debug()
        ];
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
        $lists = $this->service->displayTodoLists();

        $this->app->view->setData('lists', $lists);
        $this->app->render('admin/index.twig');
    }

    public function history($id)
    {
        $events = $this->service->displayDomainEventLog($id);

        $this->app->view->setData('events', $events);
        $this->app->render('admin/history.twig');
    }

    public function snapshot($id, $playhead)
    {
        $list = $this->service->displayTodoListAtPlayhead($id, $playhead);

        $this->app->view->setData('list', $list);
        $this->app->render('view.twig');
    }
}
