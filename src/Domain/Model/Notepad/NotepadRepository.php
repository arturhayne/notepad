<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\Note\Note;


interface NotepadRepository{
    public function ofId(NotepadId $notepadId);  
}