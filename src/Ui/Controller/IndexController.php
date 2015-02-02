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
        $this->app->render('index.twig');
    }

    public function startPlanning()
    {
        $id = $this->service->startPlanning();

        $this->app->redirect('/list/'.$id);
    }

    public function view($id)
    {
        $list = $this->service->displayTodoList($id);

        $this->app->render('view.twig', compact('list'));
    }

    public function addTask()
    {
        $id = $this->app->request->post('id');
        $task = $this->app->request->post('task');

        $this->service->addTask($id, $task);

        $this->app->redirect('/list/'.$id);
    }
}
