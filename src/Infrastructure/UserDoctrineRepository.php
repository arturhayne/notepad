<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\User\User;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;
use Doctrine\ORM\EntityManager;
use Notepad\Infrastructure\Projection\Projector;




class UserDoctrineRepository extends EntityRepository implements UserRepository 
{

    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function add(User $data)
	{
        $this->em->persist($data);
        $this->em->flush($data);
		return $data;
    }

    public function ofId(UserId $userId){
        return $this->em->find(User::class, $userId);
    }

}