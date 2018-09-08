<?php

namespace App\Http\Application;

class NoteDTO 
{
    public $title;
    public $content;

    public function __construct($aTitle,$aContent){
        $this->title = $aTitle;
        $this->content = $aContent;
    }

}