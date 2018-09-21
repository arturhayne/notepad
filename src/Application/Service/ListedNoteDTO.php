<?php

namespace Notepad\Application\Service;

class ListedNoteDTO
{
    public $id;
    public $title;
    public $content;

    /**
     * CreatedNoteDto constructor.
     * @param $id
     */
    public function __construct($id,$title,$content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }
}