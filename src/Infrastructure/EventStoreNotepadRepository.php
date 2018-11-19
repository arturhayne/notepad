<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Note\Note;

class EventStoreNotepadRepository implements NotepadRepository{

    private $eventStore;
    private $projector;

    public function __construct($eventStore, $projector){
        $this->eventStore = $eventStore;
        $this->projector = $projector;
    }

    public function save(Notepad $notepad){
        $events = $notepad->recordedEvents();
        $this->eventStore->append(
            new EventStream($notepad->id(),$events)
        );
        $notepad->clearEvents();
        $this->projector->project($events);
    }

    public function ofId(NotepadId $notepadId){
        return Notepad::reconstitute(
            $this->eventStore->getEventsFot($notepadId)
        );
    }


    public function removeNote(Note $note){
    }

    public function remove(Notepad $notepad){
    }

}