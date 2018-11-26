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
        notificationId: eventId
        notificationMessage: serialized object
        notificationType: eventName
    */
    public function send($exchangeName, $notificationMessage, $notificationType, $notificationId, \DateTime $notificationOccurredOn)
    {
        $this->projector->projectEvent($notificationType, $notificationMessage);
    }

    public function open($exchangeName){

    }
    public function close($exchangeName){

    }
}
