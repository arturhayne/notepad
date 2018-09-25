<?php

namespace Notepad\Domain\Model\User;

class User{
    protected $id;
    protected $name;
    protected $email;

    private function __construct(UserId $id,string $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
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

    public function fetchedConvertion($id, $name, $email) { 
        $userId = UserId::createFromString($id);
        return self::create($userId,$name,$email);
    }

    public function createNotepad(NotepadId $notepadId,$name){
        return Notepad::create($notepadId,$this->id, $name);
    }

}