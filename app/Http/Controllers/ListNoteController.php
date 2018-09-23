<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\Note\ListNoteHandler;

class ListNoteController extends Controller
{
    private $handler;

    public function __construct(ListNoteHandler $handler){
        $this->handler = $handler;
    }

    public function list(Request $request){
        $list = $this->handler->execute(); 
        return response()->json(['list' => $list], Response::HTTP_ACCEPTED);
    }
}
