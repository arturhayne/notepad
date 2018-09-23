<?php

namespace Notepad\Application\Service\User;

use Notepad\Domain\Model\UserRepository;
use Notepad\Domain\Model\UserId;
use Notepad\Domain\Model\User;


class CreateUserHandler{

    protected $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateUserCommand $command) : string{
        $user = Note::create(UserId::Create(),$command->name);
        $this->repository->add($user);
        return (string) $user->id();
    }

}