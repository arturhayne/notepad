<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;
use Doctrine\Common\Collections\Criteria;

use Notepad\Domain\Model\Common\AggregateRoot;

use Notepad\Domain\Model\Note\NoteWasCreated;

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

        $aNewNotepad->recordAndpublishThat(
            new NotepadWasCreated($notepadId, $userId, $name)
        );
        return $aNewNotepad;
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
            new NoteWasCreated($noteId, $this->id, $title, $content)
        );

        $this->recordAndpublishThat(
            new NumUserNotesWasIncreased($this->userId)
        );

        $this->recordAndpublishThat(
            new UsersNoteAdded($this->userId, $this->id, $noteId, $title, $content)
        );

        return $noteId;
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

    public static function reconstitute(EventStream $history){
        $notepad = new static($history->aggregateId());

        foreach($events as $event){
            $notepad->applyThat($event);
        }
        return $notepad;
    }


    public function numberNotes($qt = 0){
        //foreach($this->notepads as $notepad){
         //   $qt += count($this->notes());
        //}
        return $qt;
    }

    protected function applyNoteWasCreated(NoteWasCreated $event){
        $note = Note::create(NoteId::createFromString($event->noteId()), 
                        NotepadId::createFromString($event->aggregateId()), 
                                $event->title(), $event->content());

        $note->setNotepad($this);
        $this->notes[] = $note;
    }

}