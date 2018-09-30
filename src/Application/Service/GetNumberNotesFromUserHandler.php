<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;


class GetNumberNotesFromUserHandler{

    protected $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function execute(GetNumberNotesFromUseCommand $command){
        $user = $this->repository->ofId(UserId::createFromString($command->userId));
        return $user->numberNotes();
    }


}