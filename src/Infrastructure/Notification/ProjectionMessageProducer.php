<?php

namespace Notepad\Infrastructure\Notification;

use Notepad\Domain\Notification\ProjectorManager;
use Notepad\Infrastructure\Projection\Projector;

class ProjectionMessageProducer implements ProjectorManager
{
    private $projector;

    public function __construct(Projector $projector){
        $this->projector = $projector;
    }
    /*
        notificationMessage: serialized object
        notificationType: eventName
    */
    public function send($notificationMessage, $notificationType)
    {
        $this->projector->projectEvent($notificationType, $notificationMessage);
    }

}
