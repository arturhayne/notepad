<?php

namespace Notepad\Application\Service\Notepad;
use Illuminate\Http\Response;
use Notepad\Domain\Model\Notepad\NoteRepository;



class ListNoteHandler extends NotepadAggregateService{

    public function execute() {
        $notepads = $this->notepadRepository->findAll();
        $this->listNoteTransformer->write($notepads);
    }

    public function listNoteTransformer(){
        return $this->listNoteTransformer->read();
    }

}