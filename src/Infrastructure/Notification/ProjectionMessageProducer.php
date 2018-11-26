<?php

namespace Notepad\Infrastructure\Notification;

use Notepad\Domain\Notification\MessageProducer;
use PhpAmqpLib\Message\AMQPMessage;
use Notepad\Infrastructure\Projection\Projector;

class ProjectionMessageProducer implements MessageProducer
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
