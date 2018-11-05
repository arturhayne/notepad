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

use Notepad\Infrastructure\NotepadDoctrineRepository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools;


class NotepadRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(){
        $this->repository = $this->createNotepadRepository();
    }

    private function createNotepadRepository(){
        $this->addCustomTypes();
        $em = $this->initEntityManager();
        $this->initSchema($em);
        return new NotepadDoctrineRepository($em,$em->getClassMetaData(Notepad::class));
    }

    private function addCustomTypes(){
        if(!Type::hasType('NotepadId')){
            Type::addType (
                'NotepadId',
                'Notepad\Infrastructure\Persistence'
                . '\Doctrine\Types\DoctrineNotepadId');
        }

        if(!Type::hasType('UserId')){
            Type::addType (
                'UserId',
                'Notepad\Infrastructure\Persistence'
                . '\Doctrine\Types\DoctrineUserId');
        }

        if(!Type::hasType('NoteId')){
            Type::addType (
                'NoteId',
                'Notepad\Infrastructure\Persistence'
                . '\Doctrine\Types\DoctrineNoteId');
        }
        if(!Type::hasType('uuid')){
            Type::addType (
                'uuid',
                'Ramsey\Uuid\Doctrine\UuidType');
        }
    }

    protected function initEntityManager(){
        return EntityManager::create (
            [ 'url' => 'sqlite:///:memory:' ],Tools\Setup::createXMLMetadataConfiguration (
                [
                    'src/Infrastructure'
                    . '/Persistence/Doctrine/Mapping'
                ],
                $devMode = true)
            );
    }

    private function initSchema (EntityManager $em){
        $tool = new Tools\SchemaTool($em);
        $tool -> createSchema ([
            $em->getClassMetadata(Notepad::class),
            $em->getClassMetadata(Note::class)
        ]);
    }

    private function assertNotepadExist(NotepadId $id){
        $result = $this->repository->ofId($id);
        $this->assertNull($result);
    }
    private function assertNoteExist(NotepadId $id){
        $result = $this->repository->ofId($id);
        $this->assertEquals(count($result->notes()),0);
    }

    private function persistNotepad($name){
        $notepad = Notepad::create(NotepadId::create(),UserId::create(),$name);
        $this->repository->add($notepad);
        return $notepad;
    }

    private function persistNote($notepad, $title, $content){
        $note = $notepad->createNote($title, $content);
        $this->repository->add($notepad);
        return $note;
    }

    public function testeItShouldRemoveNotepad(){
        $notepad = $this->persistNotepad('notepad');
        $this->repository->remove($notepad);
        $this->assertNotepadExist($notepad->id());
    }

    public function testeItShouldRemoveNote(){
        $notepad = $this->persistNotepad('notepad');
        $note = $this->persistNote($notepad,'titulo','conteudo');
        $this->repository->removeNote($note);
        $this->assertNoteExist($notepad->id());
    }

    public function testPersitNoteByAmount(){
        $notepad = $this->persistNotepad('notepad');
        $numNotesBefore = count($notepad->notes());
        $this->persistNote($notepad,'titulo','conteudo');
        $result = $this->repository->ofId($notepad->id());
        $numNotesAfter = count($result->notes());
        $this->assertEquals($numNotesBefore+1,$numNotesAfter);
    }

    public function testRemoveNotepadCascadeNote(){
        $notepad = $this->persistNotepad('notepad');
        $this->persistNote($notepad,'titulo','conteudo');
        $this->repository->remove($notepad);
        $this->assertNotepadExist($notepad->id());
    }

    public function testFindAll(){
        $notepad = $this->persistNotepad('notepad');
        $notepad = $this->persistNotepad('notepad');
        $notepads = $this->repository->findAll();
        $this->assertContainsOnlyInstancesOf(Notepad::class,$notepads);
    }

    public function testFindAllCheckAmount(){
        $times = 10;
        for ($x = 1; $x <= $times; $x++) 
            $notepad = $this->persistNotepad('notepad');
        $notepads = $this->repository->findAll();
        $this->assertEquals(count($notepads),$times);
    }
}
