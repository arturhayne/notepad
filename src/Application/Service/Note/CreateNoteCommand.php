<?php

namespace Notepad\Application\Service\Note;

class CreateNoteCommand{
    public $title;
    public $content;

    public function __construct($title,$content){
        $this->title = $title;
        $this->content = $content;
    }
}