<?php

namespace Notepad\Domain\Model\EventStore;

use Notepad\Event\DomainEvent;


interface EventStoreRepository{
    public function append(DomainEvent $aDomainEvent);
    public function allStoredEventsSince($anEventId);
}