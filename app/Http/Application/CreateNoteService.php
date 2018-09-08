<?php

namespace App\Http\Application;

use App\Http\Domain\NoteRepository;
use App\Http\Application\NoteDTO;
use App\Http\Domain\NoteEntity;
use Exception;

class CreateNoteService 
{
    private $notesRepository;

    public function __construct(NoteRepository $notesRepository){
        $this->notesRepository = $notesRepository;
    }

    public function execute(NoteDTO $request){
        try{
            $note = new NoteEntity($this->notesRepository->nextId(),$request->title,$request->content);
            $this->notesRepository->create($note->id(),$note->title(),$note->content());

        }catch (Exception $e){
              //throw new RepositoryNotAvailableException();  
              return $e->getMessage();
        }

        return $note->id();
    }

}