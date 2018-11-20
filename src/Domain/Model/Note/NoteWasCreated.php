<?php

namespace Notepad\Domain\Model\Note;

use Notepad\Domain\Model\Note\NoteId;
use  Notepad\Domain\Event\DomainEvent;


class NoteWasCreated implements DomainEvent{

    private $noteId;
    protected $title;
    protected $content;

    public function __construct(NoteId $noteId, $aggregateId, $title, $content){
        $this->noteId = $noteId;
        $this->aggregateId = $aggregateId;
        $this->content = $content;
        $this->title = $title;
        $this->occurredOn = new \DateTimeImmutable();
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

}