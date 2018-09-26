<?php 

namespace Notepad\Application\Service\Note;

class ArrayListNoteTransformer implements ListNoteTransformer{

    private $array;

    public function write($list){
        foreach($list as $key=>$value){
            $this->array[$key] = new ListedNoteDTO(
                (string)$value->id(),
                (string) $value->title(),
                $value->content()
            );
        }
            
    }

    public function read(){
        return $this->array;
    }

}