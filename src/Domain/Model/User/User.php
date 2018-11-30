<?php

namespace Notepad\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Common\AggregateRoot;


class User extends AggregateRoot{
    
    /** @var Uuid */
    protected $id;

    /** @var string */
    protected $name;

    /** @var Email */
    protected $email;

    private function __construct(UserId $id,string $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function create(UserId $id,string $name, string $email){
        $newUser = new static($id,$name,Email::create($email));

        $newUser->recordApplyAndPublishThat(
            new UserWasAdded($id, $name, $email)
        );
        
        return $newUser;
    }

    public function applyUserWasAdded(UserWasAdded $event){
        $this->id = UserId::createFromString($event->aggregateId());
        $this->name = $event->name();
        $this->email = Email::create($event->email()); 
    }

    /**
     * @return UserId
     */
    public function id(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(){
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email(){
        return $this->email;
    }

}