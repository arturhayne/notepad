<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;
use App;


class NotepadRepositoryTest extends TestCase
{
    protected $repository;
    protected $user;

    public function setUp(){
        parent::setUp();
        $this->repository = App::make(NotepadRepository::class);
    }


    public function testCreateAndSave()
    {
        $notepad = Notepad::create(NotepadId::create(),
            UserId::createFromString($command->userId),$command->name);
        $user = Notepad::create(NotepadId::create(),'Jhony','teste@gmail.com');
        $this->repository->add($user);
        $this->assertDatabaseHas('users',['id'=>$user->id()]);
    }

    public function testFind(){
        $id = UserId::create();
        $user = User::create($id,'Jhony','teste@gmail.com');
        $this->repository->add($user);
        $result = $this->repository->ofId($id);
        $this->assertEquals($result,$user);
    }

    public function testFindAll(){
        $users = $this->repository->findAll();
        $this->assertContainsOnlyInstancesOf(User::class, $users);
    }
}
