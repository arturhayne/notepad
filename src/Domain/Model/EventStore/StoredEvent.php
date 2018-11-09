<?php

namespace Notepad\Domain\EventStore\EventStore;

use Notepad\Event\DomainEvent;

class StoredEvent implements DomainEvent{

    private $eventId;
    private $eventBody;
    private $ocurredOn;
    private $typeName;

    public function __construct($aTypeName, \DateTimeImmutable $aOcurredOn, $aEventBody){
        $this->eventBody = $aEventBody;
        $this->ocurredOn = $aOcurredOn;
        $this->typeName = $aTypeName;
    }

    public function eventId(){
        return $this->eventId;
    }

    public function eventBody(){
        return $this->eventBody;
    }

    public function ocurredOn(){
        return $this->ocurredOn;
    }

    public function typeName(){
        return $this->typeName;
    }

}