<?php

namespace Notepad\Infrastructure\Domain\Model\Notepad;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Notepad\Note;

use Notepad\Infrastructure\Projection\Projector;

use Notepad\Infrastructure\Projection\NoteWasAddedProjection;
use Notepad\Infrastructure\Projection\Projection;
use Notepad\Infrastructure\Domain\Model\EventStore\DoctrineEventStoreRepository;


class DoctrineNotepadRepository extends DoctrineEventStoreRepository implements NotepadRepository 
{
    public function ofId(NotepadId $notepadId){
        $history = $this->getEventsOfId($notepadId);
        return Notepad::reconstitute($history);
    }
}