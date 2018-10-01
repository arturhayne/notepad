<?php

namespace Notepad\Application\Service\Note;

class DeleteNoteCommand{

    public $noteId;
    public $notepadId;

    public function __construct($noteId,$notepadId){
        $this->noteId = $noteId;
        $this->notepadId = $notepadId;
    }

}