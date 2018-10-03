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
    protected $user;

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

    public function user(){
        return $this->user;
    }

    public function fetchedConvertion($id, $userId, $name) { 
        $notepafdId = NotepadId::createFromString($id);
        $userIde = UserId::createFromString($userId);
        return self::create($notepafdId,$userIde,$name);
    }

    public function createNote($title, $content, $noteId = null){
        
        if(count($this->notes)>=self::MAX_NOTES){
            throw new \InvalidArgumentException('Max number notes exceeded');
        }

        if($noteId===null){
            $noteId =  NoteId::create();
        }

        $note = Note::create($noteId, $this->id, $title, $content);
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

}