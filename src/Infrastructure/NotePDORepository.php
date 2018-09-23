<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\Note\Note;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\NoteRepository;
use Illuminate\Http\Response;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class NotePDORepository extends PDORepository implements NoteRepository{

    private $pdo;

    const QUERY_SELECT = "SELECT id, title, content FROM notes";
    const QUERY_INSERT = 'INSERT INTO notes (id, title, content)'
                            .' VALUES (?, ?, ?)';
    const QUERY_DELETE = 'Delete from notes where id = ?';

     public function __construct(\PDO $pdo)
     {
        $this->pdo = $pdo;
    }

    public function add(Note $note)
    {   
        $array = [ 
            $note->id(),
            $note->title(),
            $note->content()
        ];

        try {
            $this->genericExecute(self::QUERY_INSERT,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }

    public function remove(NoteId $noteId){
        
        $array = [ 
            $noteId
        ];

        try {
            $this->genericExecute(self::QUERY_DELETE,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }

    public function getAll(){
        $query = $this->pdo->prepare(self::QUERY_SELECT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_FUNC,
            array(Note::class, 'fetchedConvertion'));
    }



}