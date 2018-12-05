<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Event\DomainEvent;

class NotepadWasAdded implements DomainEvent{
    protected $id;
    protected $userId;
    protected $name;
    
    public function __construct($aggregateId, $userId, $name){
        $this->id = (string)$aggregateId;
        $this->userId = (string)$userId;
        $this->name = $name;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function setId($id){
        $this->id = $id;
    }

    public function id($id){
        $this->id = $id;
    }

    public function aggregateId()
    {
        return $this->id;
    } 

    public function userId()
    {
        return $this->userId;
    }

    public function name()
    {
        return $this->name;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }

    public static function arrayToDomainEvent(array $array){
        return new static($array['id'],$array['user_id'],$array['name']);
    }
}