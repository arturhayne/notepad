<?php

namespace Notepad\Domain\Event;

use Notepad\Domain\Model\Note\NoteId;

class NoteCreated implements DomainEvent{

    private $noteId;

    public function __construct(NoteId $noteId,$aggregateId){
        $this->noteId = $noteId;
        $this->occurredOn = new \DateTimeImmutable();
        $this->aggregateId = $aggregateId;
    }

    public function noteId(){
        return $this->noteId;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }

    public function aggregateId(){
        return $this->aggregateId;
    }

}