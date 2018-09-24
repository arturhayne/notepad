<?php

namespace Notepad\Domain\Model\Notepad;

class Notepad{

    protected $id;
    protected $name;

    public function __construct(NotepadId $notepadId, string $name){
        $this->id = $notepadId;
        $this->name = $name;
    }

    public static function create(NotepadId $notepadId, string $name){
        return new static($notepadId,$name);
    }

    public function id(){
        return $this->id;
    }

    public function name(){
        $this->name;
    }

}