<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\Notepad\NoteWasDeleted;
use PDO;


class NoteWasDeletedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return NoteWasDeleted::class;
   }

   public function project($event){
        $this->removeNote($event);
   }

   private function removeNote($event){
        $stmt = $this->pdo->prepare(
            'DELETE FROM notes 
            WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $event['note_id']
        ]);
    }




}