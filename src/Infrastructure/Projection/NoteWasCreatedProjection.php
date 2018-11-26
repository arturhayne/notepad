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
            ':id' => $event['note_id'],
            ':title'   => $event['title'],
            ':content' => $event['content'],
            ':notepad_id' => $event['notepad_id'],
        ]);
    }




}