<?php

namespace App\Http\Domain;

class NoteId
{
    private $id;

    public function __construct ($anId){
        $this->id = $anId;
    }

    public function id (){
        return $this->id;
    }

    public function equalTo(NoteId $anNoteId){
        return $anNoteId->id === $this->id ;
    }

    public static function create($id){
        $id+=1;
        return new self($id);
    }

    public function __toString(){
        return (string)$this->id;
    }

}