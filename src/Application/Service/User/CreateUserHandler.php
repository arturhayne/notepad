<?php

namespace Notepad\Application\Service\User;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\User;


class CreateUserHandler{

    protected $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateUserCommand $command) : string{
        $user = User::create(UserId::Create(),$command->name);
        $this->repository->add($user);
        return (string) $user->id();
    }

}