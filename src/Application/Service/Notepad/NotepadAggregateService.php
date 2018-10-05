<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;



abstract class NotepadAggregateService{

    protected $repository;

    public function __construct( NotepadRepository $repository){
        
        $this->repository = $repository;
    }

    protected function findNotepadOrFail($notepadId){
        
        $notepad = $this->notepadRepository->ofId(NotepadId::createFromString($notepadId));

        if($notepad == null){
            throw new \InvalidArgumentException('Note needs a Notepad');
        }

        return $notepad;
    }
} 