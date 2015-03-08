<?php

namespace TodoList\Ui\Controller;

use Pimple\Container;
use Slim\Slim;
use TodoList\Application;

class MarkovController
{
    private $app;
    private $service;

    private function __construct(
        Slim $app,
        Application\MarkovService $service
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
            $container['TodoList\Application\MarkovService']
        );
    }

    public function index()
    {
        $sets = $this->service->buildMarkovModel();

        $this->app->view->setData('sets', $sets);
        $this->app->render('markov/index.twig');
    }
}
