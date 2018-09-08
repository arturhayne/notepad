<?php

namespace App\Http\Infra;

use App\Note;
use App\Http\Domain\NoteRepository;
use App\Http\Infra\PostgresNoteRepository;

class EloquentNoteRepository extends PostgresNoteRepository implements NoteRepository
{

    private $note;

    public function __construct(){
        $this->note = new Note();
    }

    public function create($id,$aTitle,$aContent){
        $this->note->id = $id->id();
        $this->note->title = $aTitle;
        $this->note->content = $aContent;
        $this->note->save();
    }

}