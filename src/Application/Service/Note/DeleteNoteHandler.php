<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;

use Notepad\Application\Service\Notepad\NotepadAggregateService;


class DeleteNoteHandler extends NotepadAggregateService{

    public function execute(DeleteNoteCommand $command){ 
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $note = $notepad->removeNote(NoteId::createFromString($command->noteId));
        $this->notepadRepository->removeNote($note);
    }
}