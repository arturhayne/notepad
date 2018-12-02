<?php

namespace Notepad\Domain\Projection;

class ProjectedEvent
{
    private $mostRecentProjectedId;
    private $trackerId;
    private $exchangeName;

    public function __construct($exchangeName, $aMostRecentPublishedMessageId)
    {
        $this->mostRecentProjectedId = $aMostRecentPublishedMessageId;
        $this->exchangeName = $exchangeName;
    }

    public function mostRecentProjectedId()
    {
        return $this->mostRecentProjectedId;
    }

    public function updateMostRecentProjectedId($maxId)
    {
        $this->mostRecentProjectedId = $maxId;
    }

    public function trackerId()
    {
        return $this->trackerId;
    }
}
