<?php

namespace Notepad\Domain\Event;

use Notepad\Domain\Model\EventStore\StoredEvent;


/*
    A Domain Event Publisher is a Singleton class available from our 
    Bounded Context needed to publish Domain Events. It also has support 
    to attach listeners — Domain Event Subscribers — 
    that will be listening for any Domain Event they’re interested in.
*/

class DomainEventPublisher {

    private $subscribers;
    private static $instance;

    public static function instance(){
        if(null === static::$instance){
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct(){
        $this->subscribers = [];
    }

    public function clone(){
        throw new \BadMethodCallException('Clone is not supported!');
    }

    public function subscribe(DomainEventSubscriber $aDomainEventSubscriber){
        $this->subscribers[] = $aDomainEventSubscriber;
    }


    public function publish(DomainEvent $anEvent){
        foreach($this->subscribers as $aSubscriber){
            if($aSubscriber->isSubscribedTo($anEvent)){
                $aSubscriber->handle($anEvent);
            }
        }
    }

}