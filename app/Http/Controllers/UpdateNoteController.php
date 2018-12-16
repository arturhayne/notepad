<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\Notepad\UpdateNoteCommand;
use Notepad\Application\Service\Notepad\UpdateNoteHandler;

class UpdateNoteController extends Controller
{
    private $handler;

    public function __construct(UpdateNoteHandler $handler){
        $this->handler = $handler;
    }

    public function update($notepadId, $noteId, Request $request){
        $comand = new UpdateNoteCommand($noteId, $notepadId, $request->title, $request->content);
        $id = $this->handler->execute($comand); 
        return response()->json(['id' => $id], Response::HTTP_CREATED);
    }
}
