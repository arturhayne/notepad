<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Notepad\Application\Service\User\CreateUserCommand;
use Notepad\Application\Service\User\CreateUserHandler;

use Illuminate\Http\Response;

class CreateUserController extends Controller
{
    private $handler;

    public function __construct(CreateUserHandler $handler){
        $this->handler = $handler;
    }

    public function store(Request $request){
        $comand = new CreateUserCommand($request->name, $request->email);
        $id = $this->handler->execute($comand); 
        return response()->json(['id' => $id], Response::HTTP_CREATED);
    }
}
