<?php

namespace Notepad\Domain\Model;

use Ramsey\Uuid\Uuid;

class NoteId{
    protected $value;

    private function __construct($value = null){
        $this->value = $value ?: Uuid::uuid4();
    }

    public static function create ($value = null) : self{
        return new self ($value);
    }

    public static function createFromString(string $value): self
    {
        return new static(Uuid::fromBytes($value));
    }

    public static function createFromUUIdString(string $value): self
    {
        return new static($value);
    }

    public function __toString()
    {
        //Throwing an exception inside the magic __toString 
        //method is forbidden
        try {
            return (string) $this->value;
        } catch (Exception $exception) {
            return '';
        }
        
    }
}