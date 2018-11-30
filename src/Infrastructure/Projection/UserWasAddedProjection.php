<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\User\UserWasAdded;

class UserWasAddedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return UserWasAdded::class;
   }

   public function project($event){
       print_r('added');
        $this->addUser($event);
    }

    private function addUser($event){
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (id, name, email)
             VALUES (:id, :name, :email)'
        );

        $stmt->execute([
            ':id' => $event['id'],
            ':name'   => $event['name'],
            ':email' => $event['email']
        ]);
    }

}