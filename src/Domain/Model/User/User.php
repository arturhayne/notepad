<?php

namespace Notepad\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

class User{
    
    protected $id;
    protected $name;
    protected $email;
    protected $notepads;

    const MAX_NOTEPADS = 3;

    private function __construct(UserId $id,string $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->notepads = new ArrayCollection();
    }

    public static function create(UserId $id,string $name, string $email){
        return new static($id,$name,Email::create($email));
    }

    public function id(){
        return $this->id;
    }

    public function name(){
        return $this->name;
    }

    public function email(){
        return $this->email;
    }

    public function notepads(){
        return $this->notepads;
    }

    public function fetchedConvertion($id, $name, $email) { 
        $userId = UserId::createFromString($id);
        return self::create($userId,$name,$email);
    }

    public function createNotepad($name, $notepadId = null){
        
        if(count($this->notepads)>=self::MAX_NOTEPADS){
            throw new \InvalidArgumentException('Max number notepads exceeded');
        }

        if($notepadId===null){
            $notepadId =  NotepadId::create();
        }

        $npad = Notepad::create($notepadId,$this->id, $name);
        $this->notepads[] = $npad;
        return $npad;
    }

}