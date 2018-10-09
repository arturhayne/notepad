<?php

namespace Tests\Unit\Application;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notepad\Application\Service\User\CreateUserHandler;
use Notepad\Application\Service\User\CreateUserCommand;
use Notepad\Infrastructure\UserDoctrineRepository;



class CreateUserHandlerTest extends TestCase
{

    private $createUserHandler;
    private $command;

    public function setUp()
    {
        $this->prophet = new \Prophecy\Prophet;
        $repository  = $this->prophet->prophesize(UserDoctrineRepository::class);
        $stub = $repository->reveal();
        $this->createUserHandler = new CreateUserHandler($stub);
    }

    private function executeCreateUser(){
        return $this->createUserHandler->execute($this->command);
    }

    public function testeNotAllowInvalidEmail(){
        $this->expectException(\InvalidArgumentException::class);
        $this->command = new CreateUserCommand('teste','');
        $user = $this->executeCreateUser();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testEmptyName(){
        $this->command = new CreateUserCommand('','artur@gamil.com');
        $this->executeCreateUser();
        $this->assertTrue(true);
    }

    public function testReturnedFormat(){
        $this->command = new CreateUserCommand('bli','artur@gamil.com');
        $userId = $this->executeCreateUser();
        $this->assertInternalType('string',$userId);
    }

}
