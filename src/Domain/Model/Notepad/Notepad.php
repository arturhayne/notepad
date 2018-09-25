<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;

class Notepad{

    protected $id;
    protected $userId;
    protected $name;

    public function __construct(NotepadId $notepadId, UserId $userId, string $name){
        $this->id = $notepadId;
        $this->userId = $userId;
        $this->name = $name;
    }

    public static function create(NotepadId $notepadId, UserId $userId, string $name){
        return new static($notepadId,$userId,$name);
    }

    public function id(){
        return $this->id;
    }

    public function name(){
        $this->name;
    }

    public function userId(){
        $this->userId;
    }

    public function fetchedConvertion($id, $userId, $name) { 
        $notepafdId = NotepadId::createFromString($id);
        $userIde = UserdId::createFromString($userId);
        return self::create($notepafdId,$userIde,$name);
    }

}