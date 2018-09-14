<?php

namespace Notepad\Domain\Model;

interface NoteRepository{
    public function add(Note $note);
}