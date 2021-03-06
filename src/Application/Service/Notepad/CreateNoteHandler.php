<?php

namespace Notepad\Application\Service\Notepad;

use Notepad\Domain\Model\Notepad\NoteRepository;
use Notepad\Domain\Model\Notepad\NoteId;
use Notepad\Domain\Model\Notepad\Note;

use Notepad\Domain\Event\DomainEventPublisher;
use Notepad\Domain\Event\PersistDomainEventSubscriber;

use Notepad\Application\Service\Notepad\NotepadAggregateService;




class CreateNoteHandler extends NotepadAggregateService{

    public function execute(CreateNoteCommand $command) : string{
        $this->subscribe();
        $notepad = $this->findNotepadOrFail($command->notepadId);
        $noteId = $notepad->createNote($command->title,$command->content);
        return (string) $noteId;
    }

}