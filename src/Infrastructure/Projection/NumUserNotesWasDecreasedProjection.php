<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Notepad\NoteWasDeleted;
use PDO;


class NumUserNotesWasDecreasedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NoteWasDeleted::class;
   }

   public function project($event){
        $this->decreasingNumUserNotes($event);
    }

    private function decreasingNumUserNotes($event){

        $stmt = $this->pdo->prepare(
            'UPDATE num_user_notes SET num_notes = num_notes-1
            WHERE user_id = :user_id'
        );
        $stmt->execute([
            ':user_id' => $event['user_id']
        ]);
    }

}