<?php

namespace Notepad\Application\Service\Note;
use Illuminate\Http\Response;
use Notepad\Domain\Model\Note\NoteRepository;


class ListNoteHandler extends NoteAggregateService{

    public function execute() {
        $notepads = $this->notepadRepository->getAll();
        $this->listNoteTransformer->write($notepads);
    }

    public function listNoteTransformer(){
        return $this->listNoteTransformer->read();
    }

}