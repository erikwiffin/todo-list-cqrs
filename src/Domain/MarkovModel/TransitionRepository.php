<?php

namespace TodoList\Domain\MarkovModel;

use Broadway\Domain\DomainMessage;
use Broadway\ReadModel\RepositoryInterface;

interface TransitionRepository extends RepositoryInterface
{
    public function flush();
}
