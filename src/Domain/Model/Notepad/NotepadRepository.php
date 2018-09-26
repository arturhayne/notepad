<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;


interface NotepadRepository{
    public function add(Notepad $notepad);
    public function remove(NotepadId $notepadId);
    public function getAll();
    public function ofId(NotepadId $notepadId);
    public function getAllFromUser(UserId $userId);
}