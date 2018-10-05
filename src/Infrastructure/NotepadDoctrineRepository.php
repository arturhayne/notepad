<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;


class NotepadDoctrineRepository extends EntityRepository implements NotepadRepository 
{

    public function add(Notepad $notepad)
	{
        $this->_em->persist($notepad);
		$this->_em->flush($notepad);
		return $notepad;
    }

    public function ofId(NotepadId $notepadId){
        return $this->_em->find(Notepad::class, $notepadId);
    }

    public function removeNote(Notepad $notepad){}


}