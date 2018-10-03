<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;



class CreateNotepadHandler extends NotepadAggregateService{
    
    public function execute(CreateNotepadCommand $command) {
        $user = $this->findUserOrFail($command->userId);
        //\Doctrine\Common\Util\Debug::dump($user->notepads());
        $notead = $user->createNotepad($command->name);
        $this->userRepository->addNotepad($user);
        return (string)$notead->id();
    }
}