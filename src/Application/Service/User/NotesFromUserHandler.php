<?php

namespace Notepad\Application\Service\User;

use Notepad\Domain\Model\User\UserQueryRepository;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Notepad\NoteId;
use Notepad\Domain\Model\Notepad\Note;

use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;


class NotesFromUserHandler{

    protected $repository;

    public function __construct(UserQueryRepository $repository){
        $this->repository = $repository;
    }

    public function execute($userId){
        return $this->repository->getNotesFromUser(UserId::createFromString($userId));
    }
}