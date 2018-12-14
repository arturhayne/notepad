<?php


namespace Tests\Unit\Domain\Model;

use Notepad\Domain\Model\Notepad\Note;
use PHPUnit\Framework\TestCase;

use Notepad\Domain\Event\DomainEventPublisher;
use Notepad\Domain\Event\DomainEventSubscriber;


class NoteTest extends TestCase
{

    public function itShouldPublishNoteCreatedEvent(){
        //$subscriber = new SpySubscriber();
        //$id = DomainEventpublisher::instance()->subscriber($subscriber);
        //$noteId = NoteId::create();
        //$note = Note::create($noteId,'teste','teste');
    }

}