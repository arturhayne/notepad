<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\NoteRepository;


class ListNoteHandler{

    protected $repository;

    public function __construct(NoteRepository $repository){
        $this->repository = $repository;
    }

    public function execute() : array{
        $list = $this->repository->getAll();
        return $list;
    }

}