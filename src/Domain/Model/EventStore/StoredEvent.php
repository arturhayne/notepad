<?php

namespace Notepad\Domain\EventStore\EventStore;

use Notepad\Event\DomainEvent;

class StoredEvent implements DomainEvent{

    private $eventId;
    private $aggregateId;
    private $eventBody;
    private $ocurredOn;
    private $typeName;

    public function __construct($aggregateId,$aTypeName, \DateTimeImmutable $aOcurredOn, $aEventBody){
        $this->aggregateId = $aggregateId;
        $this->eventBody = $aEventBody;
        $this->ocurredOn = $aOcurredOn;
        $this->typeName = $aTypeName;
    }

    public function eventId(){
        return $this->eventId;
    }

    public function aggregateId(){
        return $this->aggregateId;
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