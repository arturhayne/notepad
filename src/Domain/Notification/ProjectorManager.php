<?php

namespace Notepad\Domain\Notification;

interface ProjectorManager
{
    public function projectEvent($type, $event);
}
