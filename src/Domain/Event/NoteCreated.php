<?php

namespace Notepad\Domain\Event;

use Notepad\Domain\Model\Note\NoteId;

class NoteCreated implements DomainEvent{

    private $noteId;

    public function __construct(NoteId $noteId){
        $this->id = $noteId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function noteId(){
        return $this->noteId;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }


}