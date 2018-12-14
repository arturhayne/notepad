<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\Notepad\DeleteNoteCommand;
use Notepad\Application\Service\Notepad\DeleteNoteHandler;

class DeleteNoteController extends Controller
{
    private $handler;

    public function __construct(DeleteNoteHandler $handler){
        $this->handler = $handler;
    }

    public function destroy($id,$notepadId){
        $comand = new DeleteNoteCommand($id,$notepadId);
        $this->handler->execute($comand); 
        return response()->json(['result' => 'OK'], Response::HTTP_ACCEPTED);
    }
}
