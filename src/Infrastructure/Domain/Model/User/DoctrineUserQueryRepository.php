<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\User\User;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;
use Doctrine\ORM\EntityManager;
use Notepad\Infrastructure\Projection\Projector;


class UserESourcingRepository extends EventStoreDoctrineRepository implements UserRepository 
{
    public function ofId(UserId $userId){
        $eventStream = $this->getEventsOfId($aggregateId);
        return User::reconstitute($eventStream);
    }
}