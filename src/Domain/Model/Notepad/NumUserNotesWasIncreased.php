<?php 

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Event\DomainEvent;

class NumUserNotesWasIncreased implements DomainEvent{

    private $userId;
    private $plsuNotes;

    public function __construct($userId){
        $this->userId = $userId;
        $this->plusNotes = 1;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function aggregateId()
    {
        return $this->userId;
    } 

    public function plsuNotes()
    {
        return $this->plsuNotes;
    } 

    public function occuredOn(){
        return $this->occurredOn;
    }


}
