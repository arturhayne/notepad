<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;


class CreateNoteHandler extends NoteService{

    const MAX_NOTES = 8;

    public function execute(CreateNoteCommand $command) : string{
        $notepad = $this->findNotepadOrFail($command->notepadId);

        $countNotes = $this->repository->qtOfNotesFromNotepad($notepad->id());

        if($countNotes>= self::MAX_NOTES){
            throw new \InvalidArgumentException('Max notes for notepad'); 
        }

        $note = Note::create(NoteId::Create(),$notepad->id(),$command->title,$command->content);
        $this->repository->add($note);
        return (string) $note->id();
    }

}