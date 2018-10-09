<?php

namespace Tests\Unit\Domain\Repository;

use Tests\TestCase;
use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;
use Notepad\Infrastructure\UserDoctrineRepository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools;

class UserRepositoryTest extends TestCase
{
    
    protected $repository;

    public function setUp(){
        $this->repository = $this->createUserRepository();
    }

    private function createUserRepository(){
        $this->addCustomTypes();
        $em = $this->initEntityManager();
        $this->initSchema($em);
        return new UserDoctrineRepository($em,$em->getClassMetaData(User::class));
    }

    private function addCustomTypes(){
        if(!Type::hasType('UserId')){
            Type::addType (
                'UserId',
                'Notepad\Infrastructure\Persistence'
                . '\Doctrine\Types\DoctrineUserId');
        }

        if(!Type::hasType('Email')){
            Type::addType (
                'Email',
                'Notepad\Infrastructure\Persistence'
                . '\Doctrine\Types\DoctrineEmail');
        }
        if(!Type::hasType('uuid')){
            Type::addType (
                'uuid',
                'Ramsey\Uuid\Doctrine\UuidType');
        }
    }

    protected function initEntityManager(){
        return EntityManager::create (
            [ 'url' => 'sqlite:///:memory:' ],Tools\Setup::createXMLMetadataConfiguration (
                [
                    'src/Infrastructure'
                    . '/Persistence/Doctrine/Mapping'
                ],
                $devMode = true)
            );
    }

    private function initSchema (EntityManager $em){
        $tool = new Tools\SchemaTool($em);
        $tool -> createSchema ([
            $em->getClassMetadata(User::class)
        ]);
    }

    public function testeItShouldRemoveUser(){
        $user = $this->persistUser('nome do usuario','teste@gmail.com');
        $this->repository->remove($user);
        $this->assertUserExist($user->id());
    }

    private function assertUserExist(UserId $id){
        $result = $this->repository->ofId($id);
        $this->assertNull($result);
    }

    private function persistUser($name,$email){
        $user = User::create(UserId::create(),$name,$email);
        $this->repository->add($user);
        return $user;
    }

}
