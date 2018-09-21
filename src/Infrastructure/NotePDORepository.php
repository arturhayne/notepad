<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\Note;
use Notepad\Domain\Model\NoteId;
use Notepad\Domain\Model\NoteRepository;
use Illuminate\Http\Response;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class NotePDORepository implements NoteRepository{

    private $pdo;
 
     public function __construct(\PDO $pdo)
     {
        $this->pdo = $pdo;
    }

    public function add(Note $note)
    {   
        $cmd = 'INSERT INTO notes (id, title, content)'
        .' VALUES (?, ?, ?)';
        $array = [ 
            $note->id(),
            $note->title(),
            $note->content()
        ];

        try {
            $this->genericExecute($cmd,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }

    private function genericExecute($command, $array){
        $this->pdo->beginTransaction();

        try {

            $query = $this->pdo->prepare($command);
            $res = $query->execute($array); 

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollback();
        }
    }

    public function remove(NoteId $noteId){
        
        $cmd = 'Delete from notes where id = ?';
        $array = [ 
            $noteId
        ];

        try {
            $this->genericExecute($cmd,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }

    public function getAll(){
        $query = $this->pdo->prepare("SELECT id, title, content FROM notes");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_FUNC,
            array('Notepad\Domain\Model\Note', 'fetchedConvertion'));
    }



}