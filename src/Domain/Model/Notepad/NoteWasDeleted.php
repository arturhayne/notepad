<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Event\DomainEvent;

class NoteWasDeleted implements DomainEvent{

    private $noteId;
    protected $notepadId;
    protected $userId;


    public function __construct($noteId, $aggregateId, $userId){
        $this->noteId = (string)$noteId;
        $this->aggregateId = (string)$aggregateId;
        $this->notepadId = (string)$aggregateId;
        $this->userId = (string)$userId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function notepadId(){
        return $this->notepadId;
    }

    public function noteId(){
        return $this->noteId;
    }

    public function userId(){
        return $this->userId;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }

    public function aggregateId(){
        return $this->aggregateId;
    }


    public static function arrayToDomainEvent(array $array){
        return new static($array['note_id'],
        $array['user_id'],
        $array['notepad_id']);
    }
    


}