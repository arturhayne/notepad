<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;


interface NotepadRepository{
    //public function add(Notepad $notepad);
    //public function remove(NotepadId $notepadId);
    //public function getAll();
    public function getAllNotepads(UserId $userId);
    public function ofId(NotepadId $notepadId);
    public function addNote(Notepad $notepad);
    public function removeNote(Notepad $notepad);
}