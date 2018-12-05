<?php

namespace Notepad\Domain\Event;


interface DomainEvent{
    public function occuredOn();
    public function aggregateId();
    public static function arrayToDomainEvent(array $arrayEvent);
}