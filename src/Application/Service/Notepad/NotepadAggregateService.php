<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\EventStore\EventStore;

use Notepad\Application\Service\Notepad\ListNoteTransformer;

use  Notepad\Domain\Event\DomainEventPublisher;
use  Notepad\Domain\Event\PersistDomainEventSubscriber;
use  Notepad\Domain\Event\DomainEvent;





abstract class NotepadAggregateService{

    protected $listNoteTransformer;
    protected $notepadRepository;

    public function __construct( 
        ListNoteTransformer $listNoteTransformer,
        NotepadRepository $notepadRepository){
        $this->listNoteTransformer = $listNoteTransformer;
        $this->notepadRepository = $notepadRepository;
    }

    protected function findNotepadOrFail($notepadId){
        $notepad = $this->notepadRepository->ofId(NotepadId::createFromString($notepadId));
        if($notepad == null){
            throw new \InvalidArgumentException('Note needs a Notepad');
        }
        return $notepad;
    }

    protected function subscribe(){
        DomainEventPublisher::instance()->subscribe(
            new PersistDomainEventSubscriber($this->notepadRepository)
        );
    }
} 