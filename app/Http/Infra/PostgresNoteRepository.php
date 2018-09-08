<?php

namespace App\Http\Infra;

use DB;
use App\Note; 
use App\Http\Domain\NoteId;

abstract class PostgresNoteRepository{

    public function nextId(){
        //return DB::select("nextval(pg_get_serial_sequence('notes', 'id'))");
        $id = Note::max('id');
        
        return NoteId::create($id);
    }

}