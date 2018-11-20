<?php

namespace Notepad\Application\Service\Note;
use Illuminate\Http\Response;
use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Application\Service\Notepad\NotepadAggregateService;



class ListNoteHandler extends NotepadAggregateService{

    public function execute() {
        $notepads = $this->notepadRepository->findAll();
        $this->listNoteTransformer->write($notepads);
    }

    public function listNoteTransformer(){
        return $this->listNoteTransformer->read();
    }

}