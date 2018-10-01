<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Notepad\NotepadRepository;

use Notepad\Domain\Model\Note\Note;
use Notepad\Domain\Model\Note\NoteId;

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

    const QUERY_OF_USER_ID = "SELECT id, name, user_id FROM notepad where user_id = ? ";

    const QUERY_INSERT_NOTE = 'INSERT INTO notes (id, title, content, notepad_id)'
    .' VALUES (?, ?, ?, ?)';

    const QUERY_SELECT_NOTE = "SELECT id, title, content, notepad_id FROM notes where notepad_id = ?";

    const QUERY_DELETE_NOTE = 'Delete from notes where id = ?';

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
        $notepad = Notepad::create($id,$userId, $fetchedNotepad['name']);

        $allNotes = $this->getAllNotes($notepadId);

        foreach($allNotes as $note){
            $notepad->createNote($note->title(),$note->content(),$note->id());
        }

        return $notepad;
    }

    public function getAllNotepads(UserId $userId){
        $array = [ 
            $userId
        ];
        
        $query = $this->pdo->prepare(self::QUERY_OF_USER_ID);
        $query->execute($array);

        $notepads = $query->fetchAll(\PDO::FETCH_FUNC,
            array(Notepad::class, 'fetchedConvertion'));
        
        foreach($notepads as $key => $notepad){

            $notepads[$key] = $this->ofId($notepad->id());
        }

        return $notepads;
    }

    public function addNote(Notepad $notepad){
        $note = $notepad->notes()->last(); 

        $array = [ 
            $note->id(),
            $note->title(),
            $note->content(),
            $note->notepadId()
        ];

        try {
            $this->genericExecute(self::QUERY_INSERT_NOTE,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
        
        return $note->id();
    }

    public function getAllNotes($notepadId){

        $array = [ 
            $notepadId
        ];

        $query = $this->pdo->prepare(self::QUERY_SELECT_NOTE);
        $query->execute($array); 
        return $query->fetchAll(\PDO::FETCH_FUNC,
            array(Note::class, 'fetchedConvertion'));
    }

    public function removeNote(Notepad $notepad){
        $notes = $notepad->notes();
        $notesFromDb = $this->getAllNotes($notepad->id());
        $arrayNote = array_diff_key($notesFromDb,$notes->toArray());
        $deleteThisNote = reset($arrayNote);
        $this->deleteNote($deleteThisNote->id());
    }

    private function deleteNote(NoteId $noteId){
        
        $array = [ 
            $noteId
        ];

        try {
            $this->genericExecute(self::QUERY_DELETE_NOTE,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }
}