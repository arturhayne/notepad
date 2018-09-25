<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;



class CreateNotepadHandler {
    
    protected $repository;
    protected $userRepository;

    public function __construct(NotepadRepository $repository, UserRepository $userRepository){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function execute(CreateNotepadCommand $command) : string{

        $user = $userRepository->ofId(new UserId($command->userId));

        if($user == null){
            throw new \InvalidArgumentException('Notepad needs an user');
        }

        $nPad = Notepad::create(NotepadId::create(),$user->id(),$command->name);
        $this->repository->add($nPad);
        return (string) $nPad->id();
    }
}