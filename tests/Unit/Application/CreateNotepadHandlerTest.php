<?php

namespace Tests\Unit\Application;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notepad\Application\Service\Notepad\CreateNotepadHandler;
use Notepad\Application\Service\Notepad\CreateNotepadCommand;
use Notepad\Domain\Model\User\UserId;

use App;

class CreateNotepadHandlerTest extends TestCase
{
    private $createNotepadHandler;
    private $command;

    protected function setUp()
    {
        parent::setUp();
        $this->createNotepadHandler = App::make(CreateNotepadHandler::class);
        $this->prophet = new \Prophecy\Prophet;
        $repository  = $this->prophet->prophesize(NotepadRepository::class);
        $notepad   = new Notepad($repository->reveal());
        $repository->add($notepad)->willReturn($notepad);
    }

    private function executeCreateNotepad(){
        return $this->createNotepadHandler->execute($this->command);
    }

    public function testCreateNotepad(){
        $this->command = new CreateNotepadCommand('name',UserId::create());
        $notepad = $this->executeCreateNotepad();
        $this->assertInstanceOf(Notepad::class, $notepad);
    }

    public function testEmptyName(){
        $this->command = new CreateNotepadCommand('',UserId::create());
        $this->executeCreateNotepad();
        $this->assertTrue(true);
    }

    public function testReturnedFormat(){
        $this->command = new CreateNotepadCommand('bli','artur@gamil.com');
        $userId = $this->executeCreateNotepad();
        $this->assertInternalType('string',$userId);
    }
}
