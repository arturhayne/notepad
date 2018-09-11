<?php

namespace App\Http\Infra;

use App\Note;
use App\Http\Domain\NoteRepository;
use App\Http\Infra\PostgresNoteRepository;

class EloquentNoteRepository extends PostgresNoteRepository implements NoteRepository
{

    public function __construct(){
        
    }

    public function create($id,$aTitle,$aContent){
        $this->note = new Note();
        $this->note->id = $id->id();
        $this->note->title = $aTitle;
        $this->note->content = $aContent;
        $this->note->save();
    }

    public function find($id){
        return Note::find($id);
    }

    public function delete(Note $note){
        $note->delete();
    }

}