<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Application\NoteDTO;
use App\Http\Application\CreateNoteService;
use App\Http\Infra\EloquentNoteRepository;

class NotesController extends Controller
{

    public function createNote(Request $request){
        $eloquent = new EloquentNoteRepository();
        $createNote = new CreateNoteService($eloquent);
        $noteDto = new NoteDTO($request->title, $request->content);
        $response = $createNote->execute($noteDto); 

        return $response;
    }


}
