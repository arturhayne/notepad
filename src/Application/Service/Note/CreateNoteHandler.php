<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;


class CreateNoteHandler{

    protected $repository;

    public function __construct(NoteRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateNoteCommand $command) : string{
        $note = Note::create(NoteId::Create(),$command->title,$command->content);
        $this->repository->add($note);
        return (string) $note->id();
    }

}