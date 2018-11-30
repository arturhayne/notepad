<?php

namespace Notepad\Domain\Notification;

interface ProjectorManager
{
    public function send($notificationMessage, $notificationType);
}
