<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;

class DeleteNoteHandler{

    protected $repository;

    public function __construct(NoteRepository $repository){
        $this->repository = $repository;
    }

    public function execute(DeleteNoteCommand $command){ 
        $noteId = NoteId::createFromString($command->id);
        $this->repository->remove($noteId);
    }
}