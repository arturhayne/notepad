<?php

namespace Notepad\Domain\Model\User;

use Notepad\Domain\Event\DomainEvent;



class UserWasAdded implements DomainEvent{

    protected $id;
    protected $email;
    protected $name;
    
    public function __construct($aggregateId, $name, $email){
        $this->id = (string)$aggregateId;
        $this->name = $name;
        $this->email = $email;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function aggregateId()
    {
        return $this->id;
    } 

    public function email()
    {
        return $this->email;
    }

    public function name()
    {
        return $this->name;
    }

    public function occuredOn(){
        return $this->occurredOn;
    }
    public static function arrayToDomainEvent(array $array){}

}