<?php

namespace Notepad\Infrastructure\Domain\Model\User;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\User\User;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;
use Doctrine\ORM\EntityManager;
use Notepad\Infrastructure\Projection\Projector;
use Notepad\Infrastructure\Domain\Model\EventStore\DoctrineEventStoreRepository;



class DoctrineUserRepository extends DoctrineEventStoreRepository implements UserRepository 
{
    public function ofId(UserId $userId){
        $eventStream = $this->getEventsOfId($aggregateId);
        return User::reconstitute($eventStream);
    }
}