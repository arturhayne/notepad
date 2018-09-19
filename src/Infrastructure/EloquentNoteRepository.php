<?php

namespace Notepad\Infrastructure;

use App\Note;
use Notepad\Domain\Model\NoteRepository;

use Notepad\Domain\Model\Note as Entity;
use Notepad\Domain\Model\NoteId;

class EloquentNoteRepository implements NoteRepository
{

    protected $note;

    public function __construct(Note $note){
        $this->note = $note;
    }

    public function add(Entity $note){
        $this->note->id = $note->id();
        $this->note->title = $note->title();
        $this->note->content = $note->content();
        $this->note->save();
    }

    public function remove(NoteId $noteId){
        $this->note->findOrFail($noteId)->delete();
    }

    public function getAll(){
        return Note::all()->toArray();
    }

}