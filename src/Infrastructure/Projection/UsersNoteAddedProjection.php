<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Notepad\NumUserNotesWasIncreased;

class UsersNoteAddedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return UsersNoteAdded::class;
   }

   public function project($event){
       print_r('teetetes');
        $this->addingUsersNote($event);
    }

    private function addingUsersNote($event){
        $stmt = $this->pdo->prepare(
            'INSERT INTO notes_from_user (user_id, note_id, notepad_id, title, content)
             VALUES (:user_id, :note_id, :notepad_id, :title, :content)'
        );

        $stmt->execute([
            ':user_id' => $event['user_id'],
            ':note_id' => $event['note_id'],
            ':notepad_id' => $event['notepad_id'],
            ':title'   => $event['title'],
            ':content' => $event['content']
        ]);
    }

}