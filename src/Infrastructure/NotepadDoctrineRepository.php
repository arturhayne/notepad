<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Note\Note;

use Notepad\Infrastructure\Projection\Projector;

use Notepad\Infrastructure\Projection\NoteWasCreatedProjection;
use Notepad\Infrastructure\Projection\Projection;


class NotepadDoctrineRepository extends EntityRepository implements NotepadRepository 
{
    private $projector;
    private $em;

    public function __construct(EntityManager $em, Projector $projector){
        $this->em = $em;
        $this->projector = $projector;
    }

    public function add(Notepad $notepad)
	{
        $this->em->persist($notepad);
        $this->em->flush($notepad);
        $this->projector->project($notepad->recordedEvents());
		return $notepad;
    }

    public function ofId(NotepadId $notepadId){
        return $this->em->find(Notepad::class, $notepadId);
    }

    public function removeNote(Note $note){
        $this->em->remove($note);
        $this->em->flush();
        return $note;
    }

    public function remove(Notepad $notepad){
        $this->em->remove($notepad);
        $this->em->flush();
        return $notepad;
    }

}