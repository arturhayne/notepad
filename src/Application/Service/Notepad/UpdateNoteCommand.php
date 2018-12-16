<?php

namespace Notepad\Application\Service\Notepad;

class UpdateNoteCommand{

    public $noteId;
    public $notepadId;
    public $title;
    public $content;

    public function __construct($noteId,$notepadId, $title, $content){
        $this->noteId = $noteId;
        $this->notepadId = $notepadId;
        $this->title = $title;
        $this->content = $content;
    }

}