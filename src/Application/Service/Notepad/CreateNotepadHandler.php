<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;



class CreateNotepadHandler {
    
    protected $repository;

    public function __construct(NotepadRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateNotepadCommand $command) : string{
        $nPad = Notepad::create(NotepadId::create(),$command->name);
        $this->repository->add($nPad);
        return (string) $nPad->id();
    }
}