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

use Notepad\Infrastructure\Projection\Projector;
use Notepad\Infrastructure\Projection\NoteWasAddedProjection; 
use Notepad\Infrastructure\Projection\UserWasAddedProjection; 
use Notepad\Infrastructure\Projection\NumUserNotesWasAddedProjection;
use Notepad\Infrastructure\Projection\NumUserNotesWasIncreasedProjection;
use Notepad\Infrastructure\Projection\NotepadWasAddedProjection; 
use Notepad\Infrastructure\Projection\UsersNoteAddedProjection; 

use Notepad\Domain\Model\User\UserQueryRepository;
use Notepad\Domain\Model\Notepad\NotepadQueryRepository;

use Notepad\Infrastructure\Notification\DoctrineProjectedEventTracker;
use Notepad\Infrastructure\Notification\ProjectionMessageProducer;
use Notepad\Domain\Notification\ProjectedEventTracker;
use Notepad\Domain\Notification\ProjectedEvent;

use Notepad\Domain\Notification\ProjectorManager;




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

        /** Projetion **/
        $pdo = new \PDO(env('STRING_CON'),
                            env('DB_USERNAME'),
                            env('DB_USERNAME'));
                            
         $this->app->bind(UserRepository::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new UserDoctrineRepository(
                $em,
                $em->getClassMetaData(User::class)
            );
        });

        $this->app->bind(UserQueryRepository::class, function($app)  use ($pdo){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new UserPDORepository(
                $pdo
            );
        });

        $this->app->bind(NotepadRepository::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new NotepadDoctrineRepository(
                $em,
                $em->getClassMetaData(Notepad::class)
            );
        });

        $this->app->bind(NotepadProjection::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new Projector(

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

        $this->app->bind(ProjectedEventTracker::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new DoctrineProjectedEventTracker(
                $em,
                $em->getClassMetaData(ProjectedEvent::class)
            );
        });

        $this->app->bind(ProjectorManager::class, function($app)  use ($pdo){

            $projector = new Projector();
            $projector->register([new NoteWasAddedProjection($pdo), 
                                    new UserWasAddedProjection($pdo),
                                    new NotepadWasAddedProjection($pdo),
                                    new NumUserNotesWasIncreasedProjection($pdo),
                                    new NumUserNotesWasAddedProjection($pdo),
                                    new UsersNoteAddedProjection($pdo)]);
            return $projector;
        });

        $this->app->bind(DomainEventSubscriber::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new PersistDomainEventSubscriber(EventStore::class);
        });
    }
}
