<?php

namespace Notepad\Domain\Model\User;

class User{
    protected $id;
    protected $name;

    private function __construct(UserId $id,string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(UserId $id,string $name){
        return new static($id,$name);
    }

    public function id(){
        return $this->id;
    }

    public function name(){
        return $this->name;
    }

}