<?php 

namespace Notepad\Domain\Model\User;

use Notepad\Domain\Event\DomainEvent;

class NumUserNotesWasAdded  implements DomainEvent{

    private $userId;
    private $numNotes;

    public function __construct($userId, $numNotes){
        $this->userId = (string)$userId;
        $this->numNotes = $numNotes;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function aggregateId()
    {
        return $this->userId;
    } 

    public function numNotes()
    {
        return $this->numNotes;
    } 

    public function occuredOn(){
        return $this->occurredOn;
    }

}
