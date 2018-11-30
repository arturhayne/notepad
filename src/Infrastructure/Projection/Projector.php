<?php

namespace Notepad\Infrastructure\Projection;
use Notepad\Domain\Model\Note\NoteWasAdded;
use Notepad\Domain\Notification\ProjectorManager;



class Projector implements ProjectorManager{

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