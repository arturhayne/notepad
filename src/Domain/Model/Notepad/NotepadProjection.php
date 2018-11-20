<?php

namespace Notepad\Domain\Notepad;

use Notepad\Domain\Note\NoteWasCreated;

interface NotepadProjection {
    
    public function projectNotepadWasCreated(NotepadWasCreated $event);

    public function projectNoteWasCreated(NoteWasCreated $event);

    public function project(DomainEvents $eventStream);

}