<?php

namespace Notepad\Infrastructure\Notification;

use Notepad\Domain\Notification\PublishedMessageTracker;
use Notepad\Domain\Notification\PublishedMessage;
use Notepad\Domain\Model\EventStore\StoredEvent;
use Doctrine\ORM\EntityRepository;

class DoctrinePublishedMessageTracker extends EntityRepository implements PublishedMessageTracker
{

    public function mostRecentPublishedMessageId($exchangeName)
    {
        $messageTracked = $this->findOneByExchangeName($exchangeName);

        if (!$messageTracked) {
            return null;
        }

        return $messageTracked->mostRecentPublishedMessageId();
    }

    public function trackMostRecentPublishedMessage($exchangeName, $notification)
    {

        if (!$notification) {
            return;
        }

        $maxId = $notification->eventId();
        
        if(!$exchangeName){
            return;
        }

        $publishedMessage = $this->find($exchangeName);

        if (!$publishedMessage) {
            $publishedMessage = new PublishedMessage(
                $exchangeName,
                $maxId
            );
        }

        $publishedMessage->updateMostRecentPublishedMessageId($maxId);

        $this->getEntityManager()->persist($publishedMessage);
        $this->getEntityManager()->flush($publishedMessage);
    }
}
