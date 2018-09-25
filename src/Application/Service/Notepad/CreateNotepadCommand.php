<?php

namespace Notepad\Application\Service\Notepad;


class CreateNotepadCommand{
    public $name;
    public $userId;

    public function __construct($name, $userId){
        $this->name = $name;
        $this->userId = $userId;
    }
}