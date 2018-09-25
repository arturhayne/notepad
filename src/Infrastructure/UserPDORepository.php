<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\UserRepository;
use Illuminate\Http\Response;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UserPDORepository extends PDORepository implements UserRepository{

    const QUERY_SELECT = "SELECT id, name FROM users";
    const QUERY_INSERT = 'INSERT INTO users (id, name, email)'
                            .' VALUES (?, ?, ?)';
    const QUERY_DELETE = 'Delete from users where id = ?';

    const QUERY_OF_ID = "SELECT id, name, email FROM users where id = ? LIMIT 1";

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
        return User::create($id, $fetchedUser['name'], $fetchedUser['email']);
    }



}