<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Notepad\Domain\Model\Notepad\NoteId;
use Notepad\Domain\Model\Notepad\Note;
use Doctrine\Common\Collections\Criteria;

use Notepad\Domain\Model\Common\AggregateRoot;
use Notepad\Domain\Model\Common\AggregateHistory;
use Notepad\Domain\Model\Common\EventSourcedAggregateRoot;

use Ramsey\Uuid\Uuid;


class Notepad extends AggregateRoot implements EventSourcedAggregateRoot{ 

    protected $id;
    protected $userId;
    protected $name;
    protected $notes;

    const MAX_NOTES = 500;

    public function __construct(NotepadId $notepadId, UserId $userId, string $name){
        $this->id = $notepadId;
        $this->userId = $userId;
        $this->name = $name;
        $this->notes = new ArrayCollection();
    }

    public static function create(NotepadId $notepadId, UserId $userId, string $name){

        $aNewNotepad = new static($notepadId, $userId, $name);
        $aNewNotepad->recordApplyAndPublishThat(
            new NotepadWasAdded($notepadId, $userId, $name)
        );

        return $aNewNotepad;
    }

    public function applyNotepadWasAdded(NotepadWasAdded $event){
        $this->id = NotepadId::createFromString($event->aggregateId());
        $this->name = $event->name();
        $this->userId = UserId::createFromString($event->userId()); 
    }

    public function id(){
        return $this->id;
    }

    public function name(){
        return $this->name;
    }

    public function userId(){
        return $this->userId;
    }

    public function notes(){
        return $this->notes;
    }

    public function createNote($title, $content){
        
        if(count($this->notes)>=self::MAX_NOTES){
            throw new \InvalidArgumentException('Max number notes exceeded');
        }
        $noteId = NoteId::create();
        $this->recordApplyAndPublishThat(
            new NoteWasAdded($noteId, $this->id, $title, $content, $this->userId)
        );
        return $noteId;
    }  

    protected function applyNoteWasAdded(NoteWasAdded $event){
        $note = Note::create(NoteId::createFromString($event->noteId()), 
                                NotepadId::createFromString($event->aggregateId()), 
                                $event->title(), 
                                $event->content());
        $note->setNotepad($this);
        $this->notes[] = $note;
    }

    protected function applyNoteWasDeleted(NoteWasDeleted $event){
        $noteId = NoteId::createFromString($event->noteId());
        $note = $this->notes[$this->findNote($noteId)];
        $note->setNotepad(null);
        unset($this->notes[$this->findNote($noteId)]);
    }


    public function removeNote(NoteId $noteId){
        $pos = $this->findNote($noteId);
        if(null === $pos){
            throw new \InvalidArgumentException('Note not found!');
        } 

        $this->recordApplyAndPublishThat(
            new NoteWasDeleted($noteId, $this->id, $this->userId)
        );
    }

    private function findNote(NoteId $noteId){
        
        foreach ($this->notes as $k => $note) {
            if( $noteId->equals($note->id()) ) {
                return $k;
                break;
            }
        }
        return null; 
    }

    public static function reconstitute(AggregateHistory $history)
    {
        $notepad = Notepad::emptyNotepad();

        foreach ($history->events() as $anEvent) {
            $notepad->applyThat($anEvent);
        }
        $notepad->clearEvents();
        return $notepad;
    }

    private static function emptyNotepad() {
        $rc = new \ReflectionClass(__CLASS__);
        return $rc->newInstanceWithoutConstructor();
    }

}