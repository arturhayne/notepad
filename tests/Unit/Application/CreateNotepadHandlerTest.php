<?php

namespace Tests\Unit\Application;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notepad\Application\Service\Notepad\CreateNotepadHandler;
use Notepad\Application\Service\Notepad\CreateNotepadCommand;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Infrastructure\NotepadDoctrineRepository;


class CreateNotepadHandlerTest extends TestCase
{
    private $createNotepadHandler;
    private $command;

    protected function setUp()
    {        
        $this->prophet = new \Prophecy\Prophet;
        $repository  = $this->prophet->prophesize(NotepadDoctrineRepository::class);
        $stub = $repository->reveal();
        $this->createNotepadHandler = new CreateNotepadHandler($stub);
    }

    private function executeCreateNotepad(){
        return $this->createNotepadHandler->execute($this->command);
    }

    public function testCreateNotepad(){
        $this->command = new CreateNotepadCommand('name',UserId::create());
        $notepadId = $this->executeCreateNotepad();
        $this->assertNotNull($notepadId);
    }

    public function testEmptyName(){
        $this->command = new CreateNotepadCommand('',UserId::create());
        $notepadId = $this->executeCreateNotepad();
        $this->assertNotNull($notepadId);
    }

    public function testReturnedFormat(){
        $this->command = new CreateNotepadCommand('bli',UserId::create());
        $notepadId = $this->executeCreateNotepad();
        $this->assertInternalType('string',$notepadId);
    }
}
