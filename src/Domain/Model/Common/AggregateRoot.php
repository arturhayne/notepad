<?php

namespace Notepad\Domain\Model\Common;

use Notepad\Domain\Event\DomainEventPublisher;
use Notepad\Domain\Event\DomainEvent;
use Notepad\Domain\Model\Notepad\Notepad;

class AggregateRoot {

    private $recordedEvents = [];

    protected function recordApplyAndPublishThat(DomainEvent $domainEvent){
        $this->recordThat($domainEvent);
        $this->applyThat($domainEvent);
        $this->publishThat($domainEvent);
    }

    protected function recordAndpublishThat(DomainEvent $domainEvent){
        $this->recordThat($domainEvent);
        $this->publishThat($domainEvent);
    }

    protected function recordThat(DomainEvent $domainEvent)
    {
        $this->recordedEvents[] = $domainEvent;
    }

    protected function applyThat(DomainEvent $domainEvent){
        $modifier = 'apply' . (new \ReflectionClass($domainEvent))->getShortName();
        $this->$modifier($domainEvent);
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