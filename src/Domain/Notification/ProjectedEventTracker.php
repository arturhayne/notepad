<?php

namespace Notepad\Domain\Notification;

interface ProjectedEventTracker
{
    /**
     * @param $aTypeName
     * @return int
     */
    public function mostRecentProjectedEventId($aTypeName);

    /**
     * @param $aTypeName
     * @param StoredEvent $notification
     */
    public function trackMostRecentProjectedEvent($aTypeName, $notification);
}
