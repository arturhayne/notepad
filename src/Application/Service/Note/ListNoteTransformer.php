<?php 

namespace Notepad\Application\Service\Note;

interface ListNoteTransformer{

    public function write($list);

    public function read();
}
