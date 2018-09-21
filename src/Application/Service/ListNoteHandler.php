<?php

namespace Notepad\Application\Service;
use Illuminate\Http\Response;
use Notepad\Domain\Model\NoteRepository;


class ListNoteHandler{

    protected $repository;

    public function __construct(NoteRepository $repository){
        $this->repository = $repository;
    }

    public function execute() {
        $list = $this->repository->getAll();
        return $this->transform($list);
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