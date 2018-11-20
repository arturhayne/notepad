<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Note\NoteWasCreated;
use PDO;


class NoteWasCreatedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NoteWasCreated::class;
   }

   public function project($event){
        $this->addNote($event);
   }

   private function addNote($event){
        $stmt = $this->pdo->prepare(
            'INSERT INTO notes (id, title, content, notepad_id)
            VALUES (:id, :title, :content, :notepad_id)'
        );

        $stmt->execute([
            ':id' => $event->noteId(),
            ':title'   => $event->title(),
            ':content' => $event->content(),
            ':notepad_id' => $event->aggregateId(),
        ]);
    }



    private function notesFromUser($event){ 
        /*$stmt = $this->pdo->query('SELECT * FROM notepad WHERE id = :id');
        $stmt->bindParam(':id', $event->aggregateId());
        $notepad = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();*/

        $stmt = $this->pdo->prepare(
            'INSERT INTO notes_from_user (user_id, note_id, notepad_id, title, content)
             VALUES (:user_id, :note_id, :notepad_id, :title, :content)'
        );

        $stmt->execute([
            ':user_id' => '1ea15c7d-a837-4f57-a20c-6f8d378c5ace', //$notepad['userId'],
            ':note_id' => $event->noteId(),
            ':notepad_id' => $event->aggregateId(),
            ':title' => $event->title(),
            ':content' => $event->content()
        ]);

    }


}