<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;



abstract class NotepadService{

    protected $repository;
    protected $userRepository;

    public function __construct(NotepadRepository $repository, UserRepository $userRepository){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    protected function findUserOrFail($userId){
        $user = $this->userRepository->ofId(UserId::createFromString($userId));

        if($user == null){
            throw new \InvalidArgumentException('Notepad needs an user');
        }

        return $user;
    }
} 