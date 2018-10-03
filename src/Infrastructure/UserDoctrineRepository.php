<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\User\User;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;


class UserDoctrineRepository extends EntityRepository implements UserRepository 
{

    public function add(User $data)
	{
        $this->_em->persist($data);
		$this->_em->flush($data);
		return $data;
    }

    public function ofId(UserId $userId){
        return $this->_em->find(User::class, $userId);
    }

    public function addNotepad(User $user){
        
    }
}