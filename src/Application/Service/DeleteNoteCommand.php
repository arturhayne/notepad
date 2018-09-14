<?php

namespace Notepad\Application\Service;

class DeleteNoteCommand{

    public $id;

    public function __construct($id){
        $this->id = $id;
    }

}