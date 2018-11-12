<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Infrastructure\NotePDORepository;

use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserRepository;
use Notepad\Infrastructure\UserPDORepository;
use Notepad\Infrastructure\UserDoctrineRepository;

use Notepad\Infrastructure\NotepadDoctrineRepository;

use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Infrastructure\NotepadPDORepository;

use Notepad\Application\Service\Note\ArrayListNoteTransformer;
use Notepad\Application\Service\Note\ListNoteTransformer;

use Notepad\Domain\DomainEventSubscriber;
use Notepad\Domain\PersistDomainEventSubscriber;

use Notepad\Domain\Model\EventStore\EventStore;
use Notepad\Infrastructure\EventStoreDoctrineRepository;
use Notepad\Domain\Model\EventStore\StoredEvent;


class NoteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        /** @var EntityManager $em */
        $em = $this->app['em'];

         $this->app->bind(UserRepository::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new UserDoctrineRepository(
                $em,
                $em->getClassMetaData(User::class)
            );
        });

        $this->app->bind(NotepadRepository::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new NotepadDoctrineRepository(
                $em,
                $em->getClassMetaData(Notepad::class)
            );
        });

         $this->app->bind(ListNoteTransformer::class, function (Application $app) {
            return new ArrayListNoteTransformer();
         });


         $this->app->bind(EventStore::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new EventStoreDoctrineRepository(
                $em,
                $em->getClassMetaData(StoredEvent::class)
            );
        });


        $this->app->bind(DomainEventSubscriber::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new PersistDomainEventSubscriber(EventStore::class);
        });
    }
}
