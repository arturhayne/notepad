<?php

namespace Notepad\Application\Service\Notification;

use Notepad\Domain\Model\EventStore\EventStore;
use JMS\Serializer\SerializerBuilder;
use Notepad\Domain\Model\EventStore\StoredEvent;
use Notepad\Domain\Notification\MessageProducer;
use Notepad\Domain\Notification\PublishedMessageTracker;
use Notepad\Domain\Model\Note\NoteWasCreated;


class NotificationService
{
    private $serializer;
    private $eventStore;
    private $publishedMessageTracker;
    private $messageProducer;

    public function __construct(
        EventStore $anEventStore,
        PublishedMessageTracker $aPublishedMessageTracker,
        MessageProducer $aMessageProducer
    )
    {
        $this->eventStore = $anEventStore;
        $this->publishedMessageTracker = $aPublishedMessageTracker;
        $this->messageProducer = $aMessageProducer;
    }

    public function publishNotifications($exchangeName)
    {
        $publishedMessageTracker = $this->publishedMessageTracker();
        $notifications = $this->listUnpublishedNotifications(
            $publishedMessageTracker->mostRecentPublishedMessageId($exchangeName)
        );

        if (!$notifications) {
            return 0;
        }

        $messageProducer = $this->messageProducer();
        $messageProducer->open($exchangeName);
        try {
            $publishedMessages = 0;
            $lastPublishedNotification = null;
            foreach ($notifications as $notification) {
                $lastPublishedNotification = $this->publish($exchangeName, $notification, $messageProducer);
                
                $publishedMessages++;
            }
        } catch(\Exception $e) {

        }

        $this->trackMostRecentPublishedMessage($publishedMessageTracker, $exchangeName, $lastPublishedNotification);
        $messageProducer->close($exchangeName);

        return $publishedMessages;
    }

    protected function publishedMessageTracker()
    {
        return $this->publishedMessageTracker;
    }

    private function listUnpublishedNotifications($mostRecentPublishedMessageId)
    {
        $storeEvents = $this->eventStore()->allStoredEventsSince($mostRecentPublishedMessageId);
        return $storeEvents;
    }

    protected function eventStore()
    {
        return $this->eventStore;
    }

    private function messageProducer()
    {
        return $this->messageProducer;
    }

    private function publish($exchangeName, StoredEvent $notification, MessageProducer $messageProducer)
    {
        
        $messageProducer->send(
            $exchangeName,
            $this->serializer()->deserialize($notification->eventBody(), 'array' , 'json'),
            $notification->typeName(),
            $notification->eventId(),
            $notification->occuredOn()
        );

        return $notification;
    }

    private function serializer()
    {
        if (null === $this->serializer) {
            $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        }
        return $this->serializer;
    }

    private function trackMostRecentPublishedMessage(PublishedMessageTracker $publishedMessageTracker, $exchangeName, $notification)
    {
        $publishedMessageTracker->trackMostRecentPublishedMessage($exchangeName, $notification);
    }
}
