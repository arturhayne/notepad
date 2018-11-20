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

    private $projector;
    private $em;

    public function __construct(EntityManager $em, Projector $projector){
        $this->em = $em;
        $this->projector = $projector;
    }

    public function add(User $data)
	{
        $this->em->persist($data);
        $this->em->flush($data);
        $this->projector->project($data->recordedEvents());        
		return $data;
    }

    public function ofId(UserId $userId){
        return $this->em->find(User::class, $userId);
    }

}