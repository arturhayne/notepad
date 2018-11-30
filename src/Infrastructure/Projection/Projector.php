<?php

namespace Notepad\Infrastructure\Projection;
use Notepad\Domain\Model\Note\NoteWasAdded;


class Projector{

    private $projections = [];

    public function register(array $projections){
        foreach($projections as $projection){
            $listenTo = $projection->listenTo();
            $this->projections[$listenTo] = $projection;
        }
    }

    public function project(array $events){
        foreach($events as $event){
            if(isset($this->projections[get_class($event)])){
                $this->projections[get_class($event)]->project($event);
            }
        }
    }

    public function projectEvent($type,$event){
        if(isset($this->projections[$type])){
            $this->projections[$type]->project($event);
        }
    }
}