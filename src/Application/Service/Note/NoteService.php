<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;



abstract class NoteService{

    protected $repository;
    protected $notepadRepository;

    public function __construct(NoteRepository $repository, NotepadRepository $notepadRepository){
        $this->repository = $repository;
        $this->notepadRepository = $notepadRepository;
    }

    protected function findNotepadOrFail($notepadId){
        
        $notepad = $this->notepadRepository->ofId(NotepadId::createFromString($notepadId));

        if($notepad == null){
            throw new \InvalidArgumentException('Note needs a Notepad');
        }

        return $notepad;
    }
} 