<?php

namespace Notepad\Domain\Model;

class Note{
    protected $id;
    protected $title;
    protected $content;

    private function __construct(NoteId $id,Title $title,string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public static function create(NoteId $id,string $title,string $content){
        return new static($id,Title::create($title),$content);
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

    public function fetchedConvertion($id, $title, $content) { 
        $noteId = NoteId::createFromString($id);
        return self::create($noteId,$title,$content);
    }
    
}