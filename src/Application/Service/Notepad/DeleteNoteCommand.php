<?php

namespace Notepad\Application\Service\Notepad;

class DeleteNoteCommand{

    public $noteId;
    public $notepadId;

    public function __construct($noteId,$notepadId){
        $this->noteId = $noteId;
        $this->notepadId = $notepadId;
    }

}