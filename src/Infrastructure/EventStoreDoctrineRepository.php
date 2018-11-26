<?php

namespace Notepad\Infrastructure;
use Doctrine\ORM\EntityRepository;

use Notepad\Domain\Model\EventStore\EventStore;
use Notepad\Domain\Event\DomainEvent;
use Notepad\Domain\Model\EventStore\StoredEvent;
use JMS\Serializer\Serializer;


class EventStoreDoctrineRepository extends EntityRepository implements EventStore 
{
    private $serializer;

    public function append(DomainEvent $aDomainEvent){
        $storedEvent =  new StoredEvent(
                $aDomainEvent->aggregateId(),
                get_class($aDomainEvent),
                $aDomainEvent->occuredOn(),
                $this->serializer()->serialize($aDomainEvent, 'json')
            );

        $this->getEntityManager()->persist($storedEvent);
    }

    public function allStoredEventsSince($anEventId){
        $query = $this->createQueryBuilder('e');
        if($anEventId){
            $query->where('e.eventId > :eventId');
            $query->setParameters(['eventId' => $anEventId ]);
        } 
        $query->orderBy('e.eventId');
        return $query->getQuery()->getResult();
    }

    private function serializer(){
        if ( null === $this -> serializer ) {
            $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        }
        return $this->serializer;
    }

}