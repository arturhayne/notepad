<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Event\DomainEventPublisher;
use Notepad\Domain\Event\DomainEvent;

class AggregateRoot {

    private $recordedEvents = [];

    protected function recordApplyAndPublishThat(DomainEvent $domainEvent){
        $this->recordThat($domainEvent);
        $this->applyThat($domainEvent);
        $this->publishThat($domainEvent);
    }

    protected function recordThat(DomainEvent $domainEvent)
    {
        $this->recordedEvents[] = $domainEvent;
    }

    protected function applyThat(DomainEvent $domainEvent){
        $modifier = 'apply' . get_class($domainEvent);
    }

    protected function publishThat(DomainEvent $domainEvent){
        DomainEventPublisher::instance()->publish($domainEvent);
    }

    public function recordedEvents(){
        return $this->recordedEvents;
    }

    public function clearEvents(){
        $this->recordedEvents = [];
    }

}