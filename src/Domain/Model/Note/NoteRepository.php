<?php

namespace Notepad\Domain\Model\Note;

use Notepad\Domain\Model\Notepad\NotepadId;

interface NoteRepository{
    public function add(Note $note);
    public function remove(NoteId $noteId);
    public function getAll();
    public function qtOfNotesFromNotepad(NotepadId $notepadId);
}