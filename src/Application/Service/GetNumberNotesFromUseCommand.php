<?php

namespace Notepad\Application\Service;

class GetNumberNotesFromUseCommand{
    public $userId;

    public function __construct($userId){
        $this->userId = $userId;
    }
}