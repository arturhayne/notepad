<?php

namespace Notepad\Domain\Model\Note;

interface NoteRepository{
    public function add(Note $note);
    public function remove(NoteId $noteId);
    public function getAll();
}