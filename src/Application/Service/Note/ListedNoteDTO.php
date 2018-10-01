<?php

namespace Notepad\Application\Service\Note;

class ListedNoteDTO
{
    public $id;
    public $title;
    public $content;
    public $notepadId;

    /**
     * CreatedNoteDto constructor.
     * @param $id
     */
    public function __construct($id,$title,$content,$notepadId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->notepadId = $notepadId;
    }
}