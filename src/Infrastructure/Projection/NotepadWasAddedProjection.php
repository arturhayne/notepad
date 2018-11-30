<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\User\UserWasAdded;
use Notepad\Domain\Model\Notepad\NotepadWasAdded;

class NotepadWasAddedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NotepadWasAdded::class;
   }

   public function project($event){
        $this->addNotepad($event);
    }

    private function addNotepad($event){
        $stmt = $this->pdo->prepare(
            'INSERT INTO notepad (id, name, user_id)
             VALUES (:id, :name, :user_id)'
        );

        $stmt->execute([
            ':id' => $event['id'],
            ':name'   => $event['name'],
            ':user_id' => $event['user_id']
        ]);
    }

}