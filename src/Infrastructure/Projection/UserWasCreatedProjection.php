<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Model\User\UserWasCreated;

class UserWasCreatedProjection implements Projection{

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

   public function listenTO(){
       return UserWasCreated::class;
   }

   public function project($event){
       print_r('entrou na projecao');
       /* $stmt = $this->pdo->query('SELECT * FROM notepad WHERE notepad_id = :notepad_id');
        $stmt->bindParam(':notepad_id', $event->getAggregateId());
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $stmt = $this->pdo->prepare(
            'INSERT INTO posts_with_comments (post_id, comment_id, title, content, state, comment)
                VALUES (:post_id, :comment_id, :title, :content, :state, :comment)'
        );

        $stmt->execute([
            ':post_id' => $event->getAggregateId(),
            ':comment_id' => $event->getCommentId(),
            ':title' => $post['title'],
            ':content' => $post['content'],
            ':state' => $post['state'],
            ':comment' => $post['comment']
            ]);*/
    }

}