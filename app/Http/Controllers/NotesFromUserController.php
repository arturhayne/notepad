<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\User\NotesFromUserHandler;

class NotesFromUserController extends Controller{
    private $handler;

    public function __construct(NotesFromUserHandler $handler){
        $this->handler = $handler;
    }

    public function allNotes($userId){
        $allNotes = $this->handler->execute($userId); 
        return response()->json($allNotes, Response::HTTP_CREATED);
    }

}