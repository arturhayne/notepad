<?php

namespace Notepad\Domain\Model\Note;

use Notepad\Domain\Model\Note\NoteId;
use  Notepad\Domain\Event\DomainEvent;


class NoteWasAdded implements DomainEvent{

    private $noteId;
    protected $title;
    protected $content;
    protected $notepadId;
    protected $userId;

    public function __construct($noteId, $aggregateId, $title, $content, $userId){
        $this->noteId = (string)$noteId;
        $this->aggregateId = (string)$aggregateId;
        $this->notepadId = (string)$aggregateId;
        $this->content = $content;
        $this->title = $title;
        $this->userId = (string)$userId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function notepadId(){
        return $this->notepadId;
    }

    public function noteId(){
        return $this->noteId;
    }

    public function content(){
        return $this->content;
    }

    public function title(){
        return $this->title;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }

    public function aggregateId(){
        return $this->aggregateId;
    }

    public function userId(){
        return $this->userId;
    }

}