<?php

namespace Notepad\Domain\Notification;

interface PublishedMessageTracker
{
    /**
     * @param $aTypeName
     * @return int
     */
    public function mostRecentPublishedMessageId($aTypeName);

    /**
     * @param $aTypeName
     * @param StoredEvent $notification
     */
    public function trackMostRecentPublishedMessage($aTypeName, $notification);
}
