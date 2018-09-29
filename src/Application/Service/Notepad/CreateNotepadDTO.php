<?php

namespace Notepad\Application\Service\Notepad;


class CreateNotepadDTO{

    public $id;
    public $name;
    public $user_id;

    public function __construct($id, $name, $userId){
        $this->id = $id;
        $this->name = $name;
        $this->user_id = $userId;
    }

}