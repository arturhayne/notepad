<?php

namespace Notepad\Domain\Model\EventStore;

use Notepad\Event\DomainEvent;


interface EventStore{
    public function append(DomainEvent $aDomainEvent);
    public function allStoredEventsSince($anEventId);
}