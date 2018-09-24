<?php

namespace Notepad\Application\Service\Notepad;


class CreateNotepadCommand{
    public $name;

    public function __construct($name){
        $this->name = $name;
    }
}