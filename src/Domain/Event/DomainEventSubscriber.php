<?php

interface DomainEventSubscriber{

    /*
    The publish method goes through all the possible subscribers, 
    checking if they’re interested in the published Domain Event. 
    If that’s the case, the handle method of the subscriber is called. 
    The subscribe method adds a new DomainEventSubscriber that will be 
    listening to specific Domain Event types
   */ 

    public function handle($aDomainEvent);

    public function isSubscribedTo($aDomainEvent);
}