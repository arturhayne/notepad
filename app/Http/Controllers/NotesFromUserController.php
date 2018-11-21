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
        $qtd = $this->handler->execute($userId); 
        return response()->json(['qtd' => $qtd], Response::HTTP_CREATED);
    }

}