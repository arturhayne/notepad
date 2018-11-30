<?php

namespace Notepad\Domain\Notepad;

use Notepad\Domain\Note\NoteWasAdded;

interface NotepadProjection {
    
    public function projectNotepadWasAdded(NotepadWasAdded $event);

    public function projectNoteWasAdded(NoteWasAdded $event);

    public function project(DomainEvents $eventStream);

}