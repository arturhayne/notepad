<?php

namespace Notepad\Domain\Model\Note;

use Notepad\Domain\Model\Notepad\NotepadId;

class Note{
    protected $id;
    protected $title;
    protected $content;
    protected $notepadId;

    private function __construct(NoteId $id, NotepadId $notepadId,Title $title,string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->notepadId = $notepadId;
    }

    public static function create(NoteId $id, NotepadId $notepadId, string $title,string $content){
        return new static($id,$notepadId,Title::create($title),$content);
    }

    public function id(){
        return $this->id;
    }

    public function title(){
        return $this->title;
    }

    public function content(){
        return $this->content;
    }

    public function notepadId(){
        return $this->notepadId;
    }

    public function fetchedConvertion($id, $notepadId, $title, $content) { 
        $noteId = NoteId::createFromString($id);
        return self::create($noteId,NotepadId::createFromString($notepadId),$title,$content);
    }
    
}