<?php

namespace App\Http\Application;

use App\Http\Domain\NoteRepository;
use App\Http\Application\NoteDTO;
use App\Http\Domain\NoteEntity;
use Exception;

class DeleteNoteService 
{
    private $notesRepository;

    public function __construct(NoteRepository $notesRepository){
        $this->notesRepository = $notesRepository;
    }

    public function execute($id){
        try{
            $note = $this->notesRepository->find($id);
            
            if(!$note){
                //throw new ();  
                return "not found";
            }

            $this->notesRepository->delete($note);

        }catch (Exception $e){
              //throw new RepositoryNotAvailableException();  
              return $e->getMessage();
        }

        return "Note Deleted";
    }

}