<?php

namespace Notepad\Domain\Model\Common;
use Notepad\Domain\Event\DomainEvent;
use Verraes\ClassFunctions\ClassFunctions;

final class AggregateHistory 
{
    
    private $serializer;
    private $aggregateId;
    private $events;

    public function __construct($aggregateId, array $storeEvents)
    {
        $this->events = [];
        foreach($storeEvents as $storedEvent) {

            if(!(string)$storedEvent->aggregateId()===$aggregateId) {
                throw new \Exception("Not same event");
            }

            $arrayEvent = $this->serializer()->deserialize(
                $storedEvent->eventBody(),
                'array',
                'json'
            );
            $type = $storedEvent->typeName();
            $event = $type::arrayToDomainEvent($arrayEvent);
            $this->events[] = $event;
        }
        $this->aggregateId = $aggregateId;
    }

    public function aggregateId()
    {
        return $this->aggregateId;
    }

    public function events(){
        return $this->events;
    }

    private function serializer(){
        if ( null === $this -> serializer ) {
            $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        }
        return $this->serializer;
    }
}