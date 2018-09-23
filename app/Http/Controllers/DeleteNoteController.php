<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\Note\DeleteNoteCommand;
use Notepad\Application\Service\Note\DeleteNoteHandler;

class DeleteNoteController extends Controller
{
    private $handler;

    public function __construct(DeleteNoteHandler $handler){
        $this->handler = $handler;
    }

    public function destroy($id){
        $comand = new DeleteNoteCommand($id);
        $this->handler->execute($comand); 
        return response()->json(['result' => 'OK'], Response::HTTP_ACCEPTED);
    }
}
