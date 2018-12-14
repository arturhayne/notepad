<?php 

namespace Notepad\Application\Service\Notepad;

interface ListNoteTransformer{

    public function write($list);

    public function read();
}
