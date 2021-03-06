<?php

namespace Notepad\Application\Service\User;

use Notepad\Domain\Model\User\UserQueryRepository;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;


class GetNumberOfNotesForUserHandler{

    protected $repository;

    public function __construct(UserQueryRepository $repository){
        $this->repository = $repository;
    }

    public function execute(GetNumberOfNotesForUserQuery $query){
        return $this->repository->getNumberNotes(UserId::createFromString($query->userId));
    }
}