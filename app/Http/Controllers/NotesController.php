<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Application\NoteDTO;
use App\Http\Application\CreateNoteService;
use App\Http\Application\DeleteNoteService;
use App\Http\Application\ListNoteService;
use App\Http\Infra\EloquentNoteRepository;

class NotesController extends Controller
{

    public function createNote(Request $request, CreateNoteService $createNote){
        $noteDto = new NoteDTO($request->title, $request->content);
        $response = $createNote->execute($noteDto); 
        return $response;
    }

    public function deleteNote($id, DeleteNoteService $deleteNote){
        $response = $deleteNote->execute($id); 
        return $response;
    }

    public function listNote(ListNoteService $listNote){
        $response = $listNote->execute(); 

        return $response;
    }


}
