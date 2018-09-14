<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\NoteRepository;
use Notepad\Domain\Model\NoteId;

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