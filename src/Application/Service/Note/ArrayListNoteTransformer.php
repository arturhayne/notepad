<?php 

namespace Notepad\Application\Service\Note;

class ArrayListNoteTransformer implements ListNoteTransformer{

    private $array;

    public function write($notepads){
        
        $list = [];
        foreach($notepads as $notepad){
            $list = array_merge($notepad->notes()->toArray(), $list);
        }

        foreach($list as $key=>$note){
            $this->array[$key] = new ListedNoteDTO(
                (string)$note->id(),
                (string) $note->title(),
                $note->content(),
                (string)$note->notepadId()
            );
        }
            
    }

    public function read(){
        return $this->array;
    }

}