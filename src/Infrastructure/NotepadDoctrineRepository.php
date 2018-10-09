<?php

namespace Notepad\Infrastructure;

use Doctrine\ORM\EntityRepository;
use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\Note\Note;



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

    public function removeNote(Note $note){
        $this->_em->remove($note);
        $this->_em->flush();
        return $note;
    }

    public function remove(Notepad $notepad){
        $this->_em->remove($notepad);
        $this->_em->flush();
        return $notepad;
    }

}