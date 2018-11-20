<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\User\UserWasCreated;

class UserWasCreatedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return UserWasCreated::class;
   }

   public function project($event){
        $this->addUser($event);
    }

    private function addUser($event){
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (id, name, email)
             VALUES (:id, :name, :email)'
        );

        $stmt->execute([
            ':id' => $event->aggregateId(),
            ':name'   => $event->name(),
            ':email' => $event->email()
        ]);
    }

}