<?php

namespace Notepad\Application\Service\Projection;

use Notepad\Domain\Model\EventStore\EventStore;
use JMS\Serializer\SerializerBuilder;
use Notepad\Domain\Model\EventStore\StoredEvent;
use Notepad\Domain\Projection\ProjectorManager;
use Notepad\Domain\Projection\ProjectedEventTracker;
use Notepad\Domain\Model\Note\NoteWasAdded;


class ProjectionService
{
    private $serializer;
    private $eventStore;
    private $eventTracker;
    private $projectorManager;

    public function __construct(
        EventStore $anEventStore,
        ProjectedEventTracker $eventTracker,
        ProjectorManager $projectorManager
    )
    {
        $this->eventStore = $anEventStore;
        $this->eventTracker = $eventTracker;
        $this->projectorManager = $projectorManager;
    }

    public function projectEvents($exchangeName)
    {
        $eventsNonProjected = $this->listNonProjectedEvents(
            $this->eventTracker->mostRecentProjectedEventId($exchangeName)
        );

        if (!$eventsNonProjected) {
            return 0;
        }

        try {
            $protectedEvents = 0;
            $lastProjectedEvent = null;
            foreach ($eventsNonProjected as $event) {
                $lastProjectedEvent = $this->publish($exchangeName, $event, $this->projectorManager);
                
                $protectedEvents++;
            }
        } catch(\Exception $e) {

        }

        $this->trackMostRecentProjectedEvent($this->eventTracker, $exchangeName, $lastProjectedEvent);

        return $protectedEvents;
    }

    private function publish($exchangeName, StoredEvent $event, ProjectorManager $projectorManager)
    {
        
        $projectorManager->projectEvent($event->typeName(),
            $this->serializer()->deserialize($event->eventBody(), 'array' , 'json')
        );

        return $event;
    }

    private function trackMostRecentProjectedEvent(ProjectedEventTracker $eventTracker, $exchangeName, $lastProjectedEvent)
    {
        $this->eventTracker->trackMostRecentProjectedEvent($exchangeName, $lastProjectedEvent);
    }

    private function listNonProjectedEvents($mostRecentPublishedMessageId)
    {
        return $this->eventStore->allStoredEventsSince($mostRecentPublishedMessageId);
    }

    private function serializer()
    {
        if (null === $this->serializer) {
            $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        }
        return $this->serializer;
    }
}
