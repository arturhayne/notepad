<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Notepad\NoteWasDeleted;
use PDO;


class UsersNoteDeletedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NoteWasDeleted::class;
   }

   public function project($event){
        $this->deletingUsersNote($event);
    }

    private function deletingUsersNote($event){
        $stmt = $this->pdo->prepare(
            'DELETE FROM notes_from_user WHERE note_id = :note_id and notepad_id = :notepad_id'
        );

        $stmt->execute([
            ':note_id' => $event['note_id'],
            ':notepad_id' => $event['notepad_id']
        ]);
    }

}