<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Event\DomainEvent;

class NotepadWasCreated implements DomainEvent{
    protected $id;
    protected $userId;
    protected $name;
    
    public function __construct($aggregateId, $userId, $name){
        $this->id = $aggregateId;
        $this->userId = $userId;
        $this->name = $name;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function aggregateId()
    {
        return $this->id;
    } 

    public function userId()
    {
        return $this->userId;
    }

    public function name()
    {
        return $this->name;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }
}