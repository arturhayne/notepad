<?php

namespace Notepad\Application\Service\Note;

class DeleteNoteCommand{

    public $id;

    public function __construct($id){
        $this->id = $id;
    }

}