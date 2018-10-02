<?php

namespace Tests\Unit\Domain\Model;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;
use App;
use DB;

class UserRepositoryTest extends TestCase
{
    
    protected $repository;

    public function setUp(){
        parent::setUp();
        $this->repository = App::make(UserRepository::class);
    }

    public function testCreateAndSave()
    {
        $user = User::create(UserId::create(),'Jhony','teste@gmail.com');
        $this->repository->add($user);
        $this->assertDatabaseHas('users',['id'=>$user->id()]);
    }


}
