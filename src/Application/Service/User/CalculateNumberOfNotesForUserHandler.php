<?php

namespace Notepad\Application\Service\User;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;


class CalculateNumberOfNotesForUserHandler{

    protected $repository;

    public function __construct(NotepadRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CalculateNumberOfNotesForUserCommand $command){
        $user = $this->repository->ofId(UserId::createFromString($command->userId));
        return $user->numberNotes();
    }
}