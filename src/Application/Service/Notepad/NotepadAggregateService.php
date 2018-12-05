<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Domain\Model\EventStore\EventStore;

use Notepad\Application\Service\Note\ListNoteTransformer;

use  Notepad\Domain\Event\DomainEventPublisher;
use  Notepad\Domain\Event\PersistDomainEventSubscriber;
use  Notepad\Domain\Event\DomainEvent;





abstract class NotepadAggregateService{

    protected $listNoteTransformer;
    protected $eventStore;

    public function __construct( 
        ListNoteTransformer $listNoteTransformer,
        EventStore $eventStore){
        $this->listNoteTransformer = $listNoteTransformer;
        $this->eventStore = $eventStore;
    }

    protected function findNotepadOrFail($notepadId){
        $history = $this->eventStore->getHistoryOfId($notepadId);
        $notepad = Notepad::reconstitute($history);
        if($notepad == null){
            throw new \InvalidArgumentException('Note needs a Notepad');
        }
        return $notepad;
    }

    protected function subscribe(){
        DomainEventPublisher::instance()->subscribe(
            new PersistDomainEventSubscriber($this->eventStore)
        );
    }
} 