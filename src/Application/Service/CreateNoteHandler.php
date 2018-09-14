<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\NoteRepository;
use Notepad\Domain\Model\NoteId;
use Notepad\Domain\Model\Note;


class CreateNoteHandler{

    protected $repository;

    public function __construct(NoteRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateNoteCommand $command) : string{
        $note = Note::create(NoteId::Create(),$command->title,$command->content);
        //print_r($note->id());
        $this->repository->add($note);
        return (string) $note->id();
    }

}