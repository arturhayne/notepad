<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NoteRepository;
use Notepad\Domain\Model\Notepad\NoteId;

class DeleteNoteHandler extends NotepadAggregateService{

    public function execute(DeleteNoteCommand $command){ 
        $this->subscribe();
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $notepad->removeNote(NoteId::createFromString($command->noteId));
    }
}