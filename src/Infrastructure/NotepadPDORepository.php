<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Notepad\NotepadRepository;

use Notepad\Domain\Model\User\UserId;
use Illuminate\Http\Response;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NotepadPDORepository extends PDORepository implements NotepadRepository{

    const QUERY_SELECT = "SELECT id, name FROM notepad";
    const QUERY_INSERT = 'INSERT INTO notepad (id, name, user_id)'
                            .' VALUES (?, ?, ?)';
    const QUERY_DELETE = 'Delete from notepad where id = ?';


    const QUERY_OF_ID = "SELECT id, name, user_id FROM notepad where id = ? LIMIT 1";

     public function __construct(\PDO $pdo)
     {
        $this->pdo = $pdo;
    }

    public function add(Notepad $npad)
    {   
        $array = [ 
            $npad->id(),
            $npad->name(),
            $npad->userId()
        ];

        try {
            $this->genericExecute(self::QUERY_INSERT,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }

    public function remove(NotepadId $nId){
        
        $array = [ 
            $nId
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
            array(Notepad::class, 'fetchedConvertion'));
    }

    public function ofId(NotepadId $notepadId){
        $array = [ 
            $notepadId
        ];

        $query = $this->pdo->prepare(self::QUERY_OF_ID);
        $query->execute($array); 
        $fetchedNotepad = $query->fetch();
        
        $id = NotepadId::create($fetchedNotepad['id']);
        $userId = UserId::create($fetchedNotepad['user_id']);
        return Notepad::create($id,$userId, $fetchedNotepad['name']);
    }
}