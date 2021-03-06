<?php

namespace Notepad\Infrastructure\Domain\Model\User;

use Notepad\Domain\Model\User\UserQueryRepository;
use Notepad\Domain\Model\User\UserId;


class PDOUserRepository implements UserQueryRepository{

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

        $result = [];

        foreach ($stm->fetchAll() as $row){
            $result[] = array('id'=>$row['id'],
            'user_id'=>$row['user_id'],
            'note_id'=>$row['note_id'],
            'notepad_id'=>$row['notepad_id'],
            'title'=>$row['title'],
            'content'=>$row['content']);
        }

        return $result;
    }

}