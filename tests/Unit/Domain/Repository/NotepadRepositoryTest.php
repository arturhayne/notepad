<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\Note\Note;
use Notepad\Domain\Model\Note\NoteId;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use App;


class NotepadRepositoryTest extends TestCase
{
    protected $repository;
    protected $userId;

    public function setUp(){
        parent::setUp();
        $this->repository = App::make(NotepadRepository::class);
        $this->createUser();
    }

    private function createUser(){
        $userRepository = App::make(UserRepository::class);
        $this->userId = UserId::create();
        $user = User::create($this->userId,'Jhony','teste@gmail.com');
        $userRepository->add($user);
        $this->assertDatabaseHas('users',['id'=>$user->id()]);
    }

    private function createNotepad($name = 'test'){
        $notepad = Notepad::create(NotepadId::create(),
            $this->userId,
            $name);
        return $notepad;
    }

    private function createSaveNote(Notepad $notepad,
                                    $title = 'title',
                                    $content = 'content'){
        $note = $notepad->createNote($title,$content);
        $this->repository->add($notepad);
        return $note;
    }

    public function testCreateAndSave()
    {
        $notepad = $this->createNotepad();
        $this->repository->add($notepad);
        $this->assertDatabaseHas('notepad',['id'=>$notepad->id()]);
    }

     public function testFind(){
        $notepad = $this->createNotepad();
        $this->repository->add($notepad);
        $result = $this->repository->ofId($notepad->id());
        $this->assertEquals($result,$notepad);
    }

    public function testFindAll(){
        $notepads = $this->repository->findAll();
        $this->assertContainsOnlyInstancesOf(Notepad::class, $notepads);
    } 

    public function testCreateSaveNote(){
        $notepad = $this->createNotepad();
        $note = $this->createSaveNote($notepad);
        $this->assertDatabaseHas('notes',['id'=>$note->id()]);
    }

    public function testDeleteNote(){
        $notepad = $this->createNotepad();
        $note = $this->createSaveNote($notepad);
        $notepadFromDB = $this->repository->ofId($notepad->id());

        $numNotes = count($notepadFromDB->notes());
        $this->repository->removeNote($note);
        $numNotesAfterRemoveNote = count($notepadFromDB->notes());

        $this->assertEquals($numNotes-1,$numNotesAfterRemoveNote);
    }
}
