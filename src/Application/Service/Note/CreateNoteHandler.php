<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;


class CreateNoteHandler extends NoteService{

    public function execute(CreateNoteCommand $command) : string{
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $note = Note::create(NoteId::Create(),$notepad->id(),$command->title,$command->content);
        $this->repository->add($note);
        return (string) $note->id();
    }

}