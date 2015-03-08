# todo-list-cqrs

A Todolist application with a CQRS architecture.

Build with [broadway](https://github.com/qandidate-labs/broadway).

## Demo

See it in action at [http://todoapp.wiffin.com/](http://todoapp.wiffin.com/).

+ The admin panel and todolist history snapshots [/admin](http://todoapp.wiffin.com/admin)
+ The markov chain summary [/markov](http://todoapp.wiffin.com/markov)

## Installation

1. Clone this module and point your server at /public.
2. Run `composer install` to download dependencies.
3. To generate the database, `php vendor/bin/doctrine orm:schema-tool:create`.
