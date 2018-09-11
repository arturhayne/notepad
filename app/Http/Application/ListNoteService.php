<?php

namespace App\Http\Application;

use App\Http\Domain\NoteRepository;
use App\Http\Application\NoteDTO;
use App\Http\Domain\NoteEntity;
use Exception;

class ListNoteService 
{
    private $notesRepository;

    public function __construct(NoteRepository $notesRepository){
        $this->notesRepository = $notesRepository;
    }

    public function execute(){
        try{
            return $this->notesRepository->list();
        }catch (Exception $e){
              //throw new RepositoryNotAvailableException();  
              return $e->getMessage();
        }
    }

}