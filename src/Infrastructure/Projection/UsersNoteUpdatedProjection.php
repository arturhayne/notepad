<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Notepad\NoteWasUpdated;

class UsersNoteUpdatedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NoteWasUpdated::class;
   }

   public function project($event){
        $this->updatingUsersNote($event);
    }

    private function updatingUsersNote($event){
        $stmt = $this->pdo->prepare(
            'update notes_from_user set title = :title, content = :content
             where note_id = :note_id'
        );

        $stmt->execute([
            ':note_id' => $event['note_id'],
            ':title'   => $event['title'],
            ':content' => $event['content']
        ]);
    }

}