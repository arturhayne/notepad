<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

class Notepad{

    protected $id;
    protected $userId;
    protected $name;
    protected $notes;

    const MAX_NOTES = 5;

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

    public function createNote($title, $content, $noteId = null){
        
        if(count($this->notes)>=self::MAX_NOTES){
            throw new \InvalidArgumentException('Max number notes exceeded');
        }

        if($noteId===null){
            $noteId =  NoteId::create();
        }

        $note = Note::create($noteId, $this->id, $title, $content);

        $note->setNotepad($this);
        $this->notes[] = $note;
        return $note;
    }

    public function removeNote(NoteId $noteId){
        foreach($this->notes as $k => $note){
            if($noteId->equals($note->id())){
                unset($this->notes[$k]);
                break;
            }
        }
        throw new \InvalidArgumentException('Note not found!');
    }


    public function numberNotes($qt = 0){
        //foreach($this->notepads as $notepad){
         //   $qt += count($this->notes());
        //}
        return $qt;
    }

}