<?php

namespace Notepad\Infrastructure\Domain\Model\EventStore;

use Doctrine\ORM\EntityRepository;

use Notepad\Domain\Model\EventStore\EventStore;
use Notepad\Domain\Event\DomainEvent;
use Notepad\Domain\Model\EventStore\StoredEvent;
use JMS\Serializer\Serializer;
use Notepad\Domain\Model\Common\AggregateHistory;
use Notepad\Domain\Model\Notepad\NotepadWasAdded;


class DoctrineEventStoreRepository extends EntityRepository implements EventStore 
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
        $this->getEntityManager()->flush($storedEvent);
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

    public function getEventsOfId($aggregateId){
        $query = $this->createQueryBuilder('e');
        if($aggregateId){
            $query->where('e.aggregateId = :aggregateId');
            $query->setParameters(['aggregateId' => $aggregateId ]);
        } 
        $query->orderBy('e.occurredOn');
        return new AggregateHistory($aggregateId, $query->getQuery()->getResult()); 
    }

    private function serializer(){
        if ( null === $this -> serializer ) {
            $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        }
        return $this->serializer;
    }

}