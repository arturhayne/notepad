<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;



class CreateNotepadHandler extends NotepadAggregateService{
    
    public function execute(CreateNotepadCommand $command) {
        $this->subscribe();
        $notepad = Notepad::create(NotepadId::create(),
            UserId::createFromString($command->userId),$command->name);
        $this->notepadRepository->add($notepad);
        return (string)$notepad->id();
    }
}