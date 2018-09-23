<?php

namespace Notepad\Application\Service\Note;
use Illuminate\Http\Response;
use Notepad\Domain\Model\Note\NoteRepository;


class ListNoteHandler{

    protected $repository;

    public function __construct(NoteRepository $repository){
        $this->repository = $repository;
    }

    public function execute() {
        
        $list = $this->repository->getAll();
        if(count($list)>0){
            return $this->transform($list);
        }
        return '';
    }

    private function transform($list){
        foreach($list as $key=>$value){
            $a[$key] = new ListedNoteDTO(
                (string)$value->id(),
                (string) $value->title(),
                $value->content()
        );
        }

        return $a;
    }

}