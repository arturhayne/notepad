<?php

namespace Notepad\Infrastructure;

use Notepad\Domain\Model\User\UserQueryRepository;
use Notepad\Domain\Model\User\UserId;


class UserPDORepository implements UserQueryRepository{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getNumberNotes(UserId $userId){
        $stm = $this->pdo->prepare('SELECT num_notes FROM num_user_notes WHERE user_id = :user_id');
        $stm->execute([
            ':user_id' => $userId
        ]);
        return $stm->fetch()['num_notes'];
    }

    public function getNotesFromUser(UserId $userId){

        $stm = $this->pdo->prepare('SELECT * FROM notes_from_user WHERE user_id = :user_id');
        $stm->execute([
            ':user_id' => $userId
        ]);
        return $stm->fetchAll();
    }

}