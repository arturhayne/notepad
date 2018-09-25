<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Notepad\Application\Service\Notepad\CreateNotepadCommand;
use Notepad\Application\Service\Notepad\CreateNotepadHandler;

use Illuminate\Http\Response;

class CreateNotepadController extends Controller
{
    private $handler;

    public function __construct(CreateNotepadHandler $handler){
        $this->handler = $handler;
    }

    public function store(Request $request){
        $comand = new CreateNotepadCommand($request->name,$request->userId);
        $id = $this->handler->execute($comand); 
        return response()->json(['id' => $id], Response::HTTP_CREATED);
    }
}
