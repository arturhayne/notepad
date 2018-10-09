<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\Note\Note;


interface NotepadRepository{
    public function findAll();
    public function ofId(NotepadId $notepadId);
    public function removeNote(Note $note);
    public function add(Notepad $notepad); 
    public function remove(Notepad $notepad);   
}