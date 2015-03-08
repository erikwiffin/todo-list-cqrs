<?php

namespace TodoList\Domain\MarkovModel;

use Broadway\Domain\DomainMessage;
class State
{
    private $id;
    private $name;

    public static function fromDomainMessage(DomainMessage $domainMessage)
    {
        $event = $domainMessage->getPayload();

        return new self(get_class($event));
    }

    public static function fromName($name)
    {
        return new self($name);
    }

    private function __construct($name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}
