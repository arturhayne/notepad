<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;
use Doctrine\Common\Collections\Criteria;

use Notepad\Domain\Event\NoteCreated;

class Notepad extends AggregateRoot{ 

    protected $id;
    protected $userId;
    protected $name;
    protected $notes;

    const MAX_NOTES = 50;

    public function __construct(NotepadId $notepadId, UserId $userId, string $name){
        $this->id = $notepadId;
        $this->userId = $userId;
        $this->name = $name;
        $this->notes = new ArrayCollection();
    }

    public static function create(NotepadId $notepadId, UserId $userId, string $name){
        return new static($notepadId,$userId,$name);
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
        $note = Note::create($noteId, $this->id, $title, $content);

        $note->setNotepad($this);
        $this->notes[] = $note;

      //  $this->recordApplyAndPublishThat(
        //     new NoteCreated($noteId));
            
        return $note;
    }

    protected function applyNotetWasCreated(NoteCreated $event){
        $this->id = $event->id();
    }        

    public function removeNote(NoteId $noteId){
        $note = $this->findNote($noteId);

        if(!$note){
            throw new \InvalidArgumentException('Note not found!');
        } 

        //Is this necessary?
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


    public function numberNotes($qt = 0){
        //foreach($this->notepads as $notepad){
         //   $qt += count($this->notes());
        //}
        return $qt;
    }

}