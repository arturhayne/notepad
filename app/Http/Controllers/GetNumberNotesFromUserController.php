<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\User\GetNumberOfNotesForUserQuery;
use Notepad\Application\Service\User\GetNumberOfNotesForUserHandler;

class GetNumberNotesFromUserController extends Controller
{
    private $handler;

    public function __construct(GetNumberOfNotesForUserHandler $handler){
        $this->handler = $handler;
    }

    public function qtdFromUser($userId){
        $query = new GetNumberOfNotesForUserQuery($userId);
        $qtd = $this->handler->execute($query); 
        return response()->json(['qtd' => $qtd], Response::HTTP_CREATED);
    }
}
