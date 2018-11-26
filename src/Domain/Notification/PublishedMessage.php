<?php

namespace Notepad\Domain\Notification;

class PublishedMessage
{
    private $mostRecentPublishedMessageId;
    private $trackerId;
    private $exchangeName;

    public function __construct($exchangeName, $aMostRecentPublishedMessageId)
    {
        $this->mostRecentPublishedMessageId = $aMostRecentPublishedMessageId;
        $this->exchangeName = $exchangeName;
    }

    public function mostRecentPublishedMessageId()
    {
        return $this->mostRecentPublishedMessageId;
    }

    public function updateMostRecentPublishedMessageId($maxId)
    {
        $this->mostRecentPublishedMessageId = $maxId;
    }

    public function trackerId()
    {
        return $this->trackerId;
    }
}
