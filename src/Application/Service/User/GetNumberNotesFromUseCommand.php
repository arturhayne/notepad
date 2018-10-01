<?php

namespace Notepad\Application\Service\User;

class GetNumberNotesFromUseCommand{
    public $userId;

    public function __construct($userId){
        $this->userId = $userId;
    }
}