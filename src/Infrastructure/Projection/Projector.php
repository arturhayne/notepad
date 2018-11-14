<?php

namespace Notepad\Infrastructure\Projection;

class Projector{
    private $projections = [];

    public function register(array $projection){
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
}