<?php

namespace Notepad\Infrastructure\Projection;
use Notepad\Domain\Model\Note\NoteWasAdded;


class Projector{

    private $projections = [];

    public function register(array $projections){
        foreach($projections as $projection){
            $listenTo = $projection->listenTo();
            $this->projections[$listenTo][] = $projection;
        }
    }

    public function projectEvent($type,$event){
        foreach($this->projections[$type] as $projection){
            $projection->project($event);
        }
    }
}