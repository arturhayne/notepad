<?php

namespace Notepad\Domain\Event;


use Notepad\Domain\Model\EventStore\EventStore;
use Notepad\Domain\Event\DomainEvent;



/*
 We can easily persist all the Domain Events published in our app by
 using a specific subscriber. Let’s create a DomainEventSubscriber 
 that will listen to all Domain Events, no matter what type, and 
 persist them using our EventStore
*/

class PersistDomainEventSubscriber implements DomainEventSubscriber{

    private $eventStore;

    public function __construct(EventStore $anEventStore){
        $this->eventStore = $anEventStore;
    }

    public function handle($aDomainEvent){
        $this->eventStore->append($aDomainEvent);
    }

    public function isSubscribedTo($aDomainEvent){
        return true;
    }

}