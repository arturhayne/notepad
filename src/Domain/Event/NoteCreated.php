<?php

namespace Notepad\Domain\Event;

class NoteCreated implements DomainEvent{

    private $noteId;

    public function __construct(NoteId $noteId){
        $this->noteId = $noteId;
        $this->occurredOn = new \DateTimeImmutable();

    }

    public function noteId(){
        return $this->noteId;
    }

    public function occurredOn(){
        return $this->occurredOn;
    }


}