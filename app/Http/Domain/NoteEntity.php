<?php

namespace App\Http\Domain;

use App\Http\Domain\NoteId;

class NoteEntity
{
    private $id;
    private $title;
    private $content;

    public function __construct(NoteId $noteId,$aTitle,$aContent){
        $this->id = $noteId;
        $this->title = $aTitle;
        $this->content = $aContent;
    }

    public function title(){
        return $this->title;
    }

    public function content(){
        return $this->content;
    }

    public function id(){
        return $this->id;
    }
}