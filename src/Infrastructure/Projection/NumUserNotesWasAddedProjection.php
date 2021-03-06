<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\User\UserWasAdded;

class NumUserNotesWasAddedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return UserWasAdded::class;
   }

   public function project($event){
        $this->addNumUserNotes($event);
    }

    private function addNumUserNotes($event){
        $stmt = $this->pdo->prepare(
            'INSERT INTO num_user_notes (user_id)
             VALUES (:id)'
        );

        $stmt->execute([
            ':id' => $event['id']
        ]);
    }

}