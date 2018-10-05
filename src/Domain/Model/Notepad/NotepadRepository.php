<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;


interface NotepadRepository{
    public function findAll();
    public function ofId(NotepadId $notepadId);
    public function removeNote(Notepad $notepad);
    public function add(Notepad $notepad);
}