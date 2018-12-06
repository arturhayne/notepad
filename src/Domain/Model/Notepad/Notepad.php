<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;
use Doctrine\Common\Collections\Criteria;

use Notepad\Domain\Model\Common\AggregateRoot;
use Notepad\Domain\Model\Common\AggregateHistory;
use Notepad\Domain\Model\Common\EventSourcedAggregateRoot;

use Notepad\Domain\Model\Note\NoteWasAdded;
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


    public function removeNote(NoteId $noteId){
        $note = $this->findNote($noteId);

        if(!$note){
            throw new \InvalidArgumentException('Note not found!');
        } 
        $this->notes->removeElement($note);
        $note->setNotepad(null);
        return $note;
    }

    private function findNote(NoteId $noteId){
        return $this->notes->matching(
            Criteria::create()->where(
                Criteria::expr()->eq('id',$noteId)
                )
            )->first();
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