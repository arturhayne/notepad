<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;
use Illuminate\Http\Response;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UserPDORepository implements UserRepository{

    private $pdo;

    const QUERY_SELECT = "SELECT id, name FROM users";
    const QUERY_INSERT = 'INSERT INTO users (id, name)'
                            .' VALUES (?, ?)';
    const QUERY_DELETE = 'Delete from users where id = ?';

     public function __construct(\PDO $pdo)
     {
        $this->pdo = $pdo;
    }

    public function add(User $user)
    {   
        $array = [ 
            $note->id(),
            $note->name()
        ];

        try {
            $this->genericExecute(QUERY_INSERT,$array);
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

    public function remove(UserId $userId){
        
        $array = [ 
            $userId
        ];

        try {
            $this->genericExecute(QUERY_DELETE,$array);
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