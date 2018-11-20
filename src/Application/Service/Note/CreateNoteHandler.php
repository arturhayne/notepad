<?php

namespace Notepad\Application\Service\Note;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Domain\Model\Note\NoteId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Domain\Event\DomainEventPublisher;
use Notepad\Domain\Event\PersistDomainEventSubscriber;

use Notepad\Application\Service\Notepad\NotepadAggregateService;




class CreateNoteHandler extends NotepadAggregateService{

    public function execute(CreateNoteCommand $command) : string{
        $this->subscribe();
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $noteId = $notepad->createNote($command->title,$command->content);
        $this->notepadRepository->add($notepad);
        return (string) $noteId;
    }

}