<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NoteRepository;
use Notepad\Domain\Model\Notepad\NoteId;

class UpdateNoteHandler extends NotepadAggregateService{

    public function execute(UpdateNoteCommand $command){ 
        $this->subscribe();
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $notepad->updateNote(NoteId::createFromString($command->noteId),
            $command->title, 
            $command->content);
    }
}