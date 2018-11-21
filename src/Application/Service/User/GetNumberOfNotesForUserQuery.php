<?php

namespace Notepad\Application\Service\User;

class GetNumberOfNotesForUserQuery
{
    public $userId;

    public function __construct($userId){
        $this->userId = $userId;
    }
}