<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListUserController extends Controller
{
    private $handler;

    public function __construct(ListUserHandler $handler){
        $this->handler = $handler;
    }

    public function list(Request $request){
        $list = $this->handler->execute(); 
        return response()->json(['list' => $this->handler->listNoteTransformer()], Response::HTTP_ACCEPTED);
    }
}
