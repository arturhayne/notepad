<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\User\CalculateNumberOfNotesForUserHandler;
use Notepad\Application\Service\User\GCalculateNumberOfNotesForUserCommand;

class GetNumberNotesFromUserController extends Controller
{
    private $handler;

    public function __construct(GetNumberNotesFromUserHandler $handler){
        $this->handler = $handler;
    }

    public function qtdFromUser($userId){
        $comand = new GCalculateNumberOfNotesForUserCommand($userId);
        $qtd = $this->handler->execute($comand); 
        return response()->json(['qtd' => $qtd], Response::HTTP_CREATED);
    }
}
