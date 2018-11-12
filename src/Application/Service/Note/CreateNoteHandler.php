<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Domain\Event\DomainEventPublisher;
use Notepad\Domain\Event\PersistDomainEventSubscriber;




class CreateNoteHandler extends NoteAggregateService{

    public function execute(CreateNoteCommand $command) : string{
        $this->subscribe();
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $note = $notepad->createNote($command->title,$command->content);
        $this->notepadRepository->add($notepad);
        return (string) $note->id();
    }

    private function subscribe(){
        DomainEventPublisher::instance()->subscribe(
            new PersistDomainEventSubscriber($this->eventStore)
        );
    }

}