<?php

namespace Notepad\Domain\Model\Notepad;

interface NotepadRepository{
    public function ofId(NotepadId $notepadId);  
}