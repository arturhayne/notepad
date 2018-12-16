<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Notepad\NoteWasAdded;
use PDO;


class NoteWasUpdatedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NoteWasUpdated::class;
   }

   public function project($event){
        $this->updateNote($event);
   }

   private function updateNote($event){
        $stmt = $this->pdo->prepare(
            'UPDATE notes SET title = :title, content = :content where 
            id = :id'
        );

        $stmt->execute([
            ':id' => $event['note_id'],
            ':title'   => $event['title'],
            ':content' => $event['content']
        ]);
    }




}