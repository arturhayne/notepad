<?php

namespace Notepad\Domain\Model\EventStore;

use Notepad\Domain\Event\DomainEvent;

class StoredEvent implements DomainEvent{

    private $eventId;
    private $aggregateId;
    private $eventBody;
    private $occurredOn;
    private $typeName;

    public function __construct($aggregateId, $aTypeName, \DateTimeImmutable $aOcurredOn, $aEventBody){
        $this->aggregateId = (string)$aggregateId;
        $this->eventBody = $aEventBody;
        $this->occurredOn = $aOcurredOn;
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

    public function occuredOn(){
        return $this->occurredOn;
    }

    public function typeName(){
        return $this->typeName;
    }

    public static function arrayToDomainEvent(array $array){}


}