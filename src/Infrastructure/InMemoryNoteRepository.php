<?php 

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\Note;
use Notepad\Domain\Model\NoteId;
use Notepad\Domain\Model\NoteRepository;

use Illuminate\Support\Collection;


class InMemoryNoteRepository implements NoteRepository{
    protected $notes;

    public function __construct()
    {
        $this->notes = new Collection();
    }

    public function add(Note $note)
    {
        $this->notes[] = $note;
    }
}