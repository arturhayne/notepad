<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;



class CreateNotepadHandler extends NotepadService{
    
    public function execute(CreateNotepadCommand $command) : string{
        $user = $this->findUserOrFail($command->userId);
        $nPad = Notepad::create(NotepadId::create(),$user->id(),$command->name);
        $this->repository->add($nPad);
        return (string) $nPad->id();
    }
}