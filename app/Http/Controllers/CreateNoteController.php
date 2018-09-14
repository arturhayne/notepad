<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\CreateNoteCommand;
use Notepad\Application\Service\CreateNoteHandler;

class CreateNoteController extends Controller
{

    private $handler;

    public function __construct(CreateNoteHandler $handler){
        $this->handler = $handler;
    }

    public function store(Request $request){
        $comand = new CreateNoteCommand($request->title, $request->content);
        $id = $this->handler->execute($comand); 
        return response()->json(['id' => $id], Response::HTTP_CREATED);
    }
}
