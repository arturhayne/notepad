<?php 

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Event\DomainEvent;

class UsersNoteAdded implements DomainEvent{

    private $userId;
    private $notepadId;
    private $noteId;
    private $title;
    private $content;

    public function __construct($userId, $notepadId, $noteId, $title, $content){
        $this->userId = $userId;
        $this->notepadId = $notepadId;
        $this->noteId = $noteId;
        $this->title = $title;
        $this->content = $content;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function aggregateId()
    {
        return $this->userId;
    } 

    public function noteId(){
        return $this->id;
    }

    public function title(){
        return $this->title;
    }

    public function content(){
        return $this->content;
    }

    public function notepadId(){
        return $this->notepadId;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }


}
