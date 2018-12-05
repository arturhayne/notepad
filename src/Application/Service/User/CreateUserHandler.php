<?php

namespace Notepad\Application\Service\User;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\EventStore\EventStore;
use  Notepad\Domain\Event\DomainEventPublisher;
use  Notepad\Domain\Event\PersistDomainEventSubscriber;
use  Notepad\Domain\Event\DomainEvent;



class CreateUserHandler{

    protected $repository;
    protected $eventStore;

    public function __construct(EventStore $eventStore){
        $this->eventStore = $eventStore;
    }

    public function execute(CreateUserCommand $command) : string{
        $this->subscribe();
        $user = User::create(UserId::Create(),$command->name,$command->email);
        return (string) $user->id();
    }

    protected function subscribe(){
        DomainEventPublisher::instance()->subscribe(
            new PersistDomainEventSubscriber($this->eventStore)
        );
    }

}