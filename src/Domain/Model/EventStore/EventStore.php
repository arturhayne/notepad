<?php

namespace Notepad\Domain\Model\EventStore;

use Notepad\Domain\Event\DomainEvent;


interface EventStore{
    public function append(DomainEvent $aDomainEvent);
    public function allStoredEventsSince($anEventId);
}