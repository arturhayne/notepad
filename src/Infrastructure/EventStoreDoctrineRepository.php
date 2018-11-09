<?php

namespace Notepad\Infrastructure;

use \JMS\Serializer\Serializer\SerializerBuilder;

class EventStoreDoctrineRepository extends EntityRepository implements EventStoreRepository 
{
    private $serializer;

    public function append(DomainEvent $aDomainEvent){
        $storedEvent =  new StoredEvent(get_class($aDomainEvent),
                $aDomainEvent -> occurredOn (),
                $this->serializer()->serialize($aDomainEvent, 'json')
            );

        $this->getEntityManager()->persist($storedEvent);
    }

    public function allStoredEventsSince($anEventId){
        $query = $this->createQueryBuilder('e');
        if($anEventId){
            $query->where('e.eventId > :eventId');
            $query->setParamenters(['eventId' => $anEventId ]);
        } 
        $query->orderBy('e.eventId');
        return $query->getQuery()->getResult();
    }

    private function seriaalizer(){
        if ( null === $this -> serializer ) {
            $this->serializer = SerializerBuilder::create()->build ();
        }
        return $this->serializer;
    }

}