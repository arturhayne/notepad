<?php

namespace Notepad\Domain\Notification;

interface MessageProducer
{
    //public function open($exchangeName);

    /**
     * @param $exchangeName
     * @param string $notificationMessage
     * @param string $notificationType
     * @param int $notificationId
     * @param \DateTime $notificationOccurredOn
     * @return
     */
    public function send($notificationMessage, $notificationType);

    //public function close($exchangeName);
}
