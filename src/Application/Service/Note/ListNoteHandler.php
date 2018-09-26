<?php

namespace Notepad\Application\Service\Note;
use Illuminate\Http\Response;
use Notepad\Domain\Model\Note\NoteRepository;


class ListNoteHandler{

    protected $repository;
    private $listNoteTransformer;

    public function __construct(NoteRepository $repository, ListNoteTransformer $listNoteTransformer){
        $this->repository = $repository;
        $this->listNoteTransformer = $listNoteTransformer;
    }

    public function execute() {
        $list = $this->repository->getAll();
        $this->listNoteTransformer->write($list);
    }

    public function listNoteTransformer(){
        return $this->listNoteTransformer->read();
    }

}