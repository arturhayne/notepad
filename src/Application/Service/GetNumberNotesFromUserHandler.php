<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Domain\Model\User\UserId;

class GetNumberNotesFromUserHandler{

    protected $notepadRepository;
    protected $noteRepository;

    public function __construct(NotepadRepository $notepadRepository, NoteRepository $noteRepository){
        $this->notepadRepository = $notepadRepository;
        $this->noteRepository = $noteRepository;
    }

    public function execute(GetNumberNotesFromUseCommand $command){

        $notepadsOfUser = $this->notepadRepository->getAllFromUser(UserId::createFromString($command->userId));
        $qt = 0;
        
        foreach($notepadsOfUser as $notepad){
            $qt+=$this->noteRepository->qtOfNotesFromNotepad($notepad->id());
        }
        
        return $qt;
    }
}