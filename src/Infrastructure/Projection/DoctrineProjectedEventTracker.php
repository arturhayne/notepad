<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Projection\ProjectedEventTracker;
use Notepad\Domain\Projection\ProjectedEvent;
use Notepad\Domain\Model\EventStore\StoredEvent;
use Doctrine\ORM\EntityRepository;

class DoctrineProjectedEventTracker extends EntityRepository implements ProjectedEventTracker
{

    public function mostRecentProjectedEventId($exchangeName)
    {
        $eventTracked = $this->findOneByExchangeName($exchangeName);
        if (!$eventTracked) {
            return null;
        }

        return $eventTracked->mostRecentProjectedId();
    }

    public function trackMostRecentProjectedEvent($exchangeName, $event)
    {

        if (!$event) {
            return;
        }

        $maxId = $event->eventId();
        if(!$exchangeName){
            return;
        }

        $projectedEvent = $this->findOneByExchangeName($exchangeName);

        if (null === $projectedEvent) {
            $projectedEvent = new ProjectedEvent(
                $exchangeName,
                $maxId
            );
        }

        $projectedEvent->updateMostRecentProjectedId($maxId);

        $this->getEntityManager()->persist($projectedEvent);
        $this->getEntityManager()->flush($projectedEvent);
    }
}
