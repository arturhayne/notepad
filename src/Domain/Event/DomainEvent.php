<?php

namespace Notepad\Domain\Event;


interface DomainEvent{
    public function occuredOn();
    public function aggregateId();
}