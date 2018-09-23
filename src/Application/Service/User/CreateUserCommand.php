<?php

namespace Notepad\Application\Service\User;

class CreateUserCommand{
    public $name;

    public function __construct($name){
        $this->name = $name;
    }
}