<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;
use Illuminate\Http\Response;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Note\Note;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UserPDORepository extends PDORepository implements UserRepository{

    const QUERY_SELECT = "SELECT id, name FROM users";
    const QUERY_INSERT = 'INSERT INTO users (id, name, email)'
                            .' VALUES (?, ?, ?)';
    const QUERY_DELETE = 'Delete from users where id = ?';

    const QUERY_OF_ID = "SELECT id, name, email FROM users where id = ? LIMIT 1";

    const QUERY_INSERT_NOTEPAD = 'INSERT INTO notepad (id, name, user_id)'
    .' VALUES (?, ?, ?)';

    const QUERY_SELECT_NOTE = "SELECT id, title, content, notepad_id FROM notes where notepad_id = ?";


    const QUERY_SELECT_NOTEPAD = "SELECT id, name, user_id FROM notepad where user_id = ?";

     public function __construct(\PDO $pdo)
     {
        $this->pdo = $pdo;
    }

    public function add(User $user)
    {   
        $array = [ 
            $user->id(),
            $user->name(),
            $user->email()
        ];

        try {
            $this->genericExecute(self::QUERY_INSERT,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
    }

    public function remove(UserId $userId){
        
        $array = [ 
            $userId
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
            array(User::class, 'fetchedConvertion'));
    }

    public function ofId(UserId $userId){
        $array = [ 
            $userId
        ];

        $query = $this->pdo->prepare(self::QUERY_OF_ID);
        $query->execute($array); 
        $fetchedUser = $query->fetch();
        $id = UserId::create($fetchedUser['id']);
        $user = User::create($id, $fetchedUser['name'], $fetchedUser['email']);

        $allNotepads = $this->getAllNotepads($userId);
        
        foreach($allNotepads as $notepad){
            $addedNotepad = $user->createNotepad($notepad->name(),$notepad->id());
            $allNotes = $this->getAllNotes($addedNotepad->id());
            foreach($allNotes as $note){
                $addedNotepad->createNote($note->title(),$note->content(),$note->id());
            }
        }

        return $user;
    }

    public function addNotepad(User $user)
    {   
        
        $npad = $user->notepads()->last(); 
        $array = [ 
            $npad->id(),
            $npad->name(),
            $npad->userId()
        ];

        try {
            $this->genericExecute(self::QUERY_INSERT_NOTEPAD,$array);
        } catch (Exception $e) {
            throw new UnableToCreatePostException($e);
        }
        
        return $npad->id();
    }

    public function getAllNotepads(UserId $userId){

        $array = [ 
            $userId
        ];

        $query = $this->pdo->prepare(self::QUERY_SELECT_NOTEPAD);
        $query->execute($array); 
        $notepads =  $query->fetchAll(\PDO::FETCH_FUNC,
            array(Notepad::class, 'fetchedConvertion'));

        foreach($notepads as $key => $notepad){
            $allNotes = $this->getAllNotes($notepad->id());
            foreach($allNotes as $note){
                $notepad->createNote($note->title(),$note->content(),$note->id());
            }
            $notepads[$key] = $notepad;
        }

        return $notepads;
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

}