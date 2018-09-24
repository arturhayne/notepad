<?php

namespace Notepad\Domain\Model\Notepad;


interface NotepadRepository{
    public function add(Notepad $notepad);
    public function remove(NotepadId $notepadId);
    public function getAll();
}