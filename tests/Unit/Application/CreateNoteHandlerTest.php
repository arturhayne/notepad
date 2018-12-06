<?php

namespace Tests\Unit\Application;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notepad\Application\Service\Note\CreateNoteHandler;
use Notepad\Application\Service\Note\CreateNoteCommand;
use Notepad\Application\Service\Note\ArrayListNoteTransformer;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\User\UserId;


use Prophecy\Argument;


class CreateNoteHandlerTest extends TestCase
{
    private $createNoteHandler;
    private $command;
    private $notepadId;

    protected function setUp()
    {
        $this->notepadId = NotepadId::create();  
        $notepad = Notepad::create($this->notepadId,UserId::create(),'name');
        $this->createNoteHandler = $this->prophesize(CreateNoteHandler::class);
        $this->createNoteHandler->findNotepadOrFail($this->notepadId)->willReturn($notepad);
    }
    
    private function executeCreateNote(){
        return $this->createNoteHandler->execute($this->command);
    }

    public function testCreateNote(){
        $this->command = new CreateNoteCommand('titulo','conteudo',$this->notepadId);
        $noteId = $this->executeCreateNote();
        $this->assertNotNull($noteId);
    }

    public function testEmptyTitle(){
        $this->command = new CreateNoteCommand('titulo','conteudo',$this->notepadId);
        $noteId = $this->executeCreateNote();
        $this->assertNotNull($noteId);
    }

    /*public function testReturnedFormat(){
        $this->command = new CreateNoteCommand('titulo','conteudo',$this->notepadId);
        $noteId = $this->executeCreateNote();
        $this->assertInternalType("string",$noteId);
    }*/

}
