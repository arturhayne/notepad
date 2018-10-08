<?php

namespace Notepad\Application\Service\User;

class CalculateNumberOfNotesForUserCommand{
    public $userId;

    public function __construct($userId){
        $this->userId = $userId;
    }
}