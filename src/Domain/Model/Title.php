<?php

namespace Notepad\Domain\Model;

class Title{

    protected $value;

    private function __construct($value){
        $this->validateValue($value);
        $this->value = $value;
    }

    public static function create($value) : self{
        return new static ($value);
    }

    public function __toString(){
        return $this->value;
    }

    private function validateValue($value){
        if(!is_string($value)||!strlen($value)){
            throw new \InvalidArgumentException('Titles can not be null');
        }

        if(strlen($value) > 20){
            throw new \InvalidArgumentException('Titles can not be bigger than 2`0 chars');
        }
    }
}