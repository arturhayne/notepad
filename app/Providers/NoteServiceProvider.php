<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;


use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserRepository;
use Notepad\Infrastructure\Domain\Model\User\PDOUserRepository;
use Notepad\Infrastructure\DoctrineUserRepository;


use Notepad\Domain\Model\Notepad\Notepad;

use Notepad\Domain\Model\Notepad\NotepadRepository;

use Notepad\Application\Service\Notepad\ArrayListNoteTransformer;
use Notepad\Application\Service\Notepad\ListNoteTransformer;

use Notepad\Domain\DomainEventSubscriber;
use Notepad\Domain\PersistDomainEventSubscriber;

use Notepad\Domain\Model\EventStore\EventStore;
use Notepad\Infrastructure\Domain\Model\EventStore\DoctrineEventStoreRepository;
use Notepad\Domain\Model\EventStore\StoredEvent;

use Notepad\Infrastructure\Projection\Projector;
use Notepad\Infrastructure\Projection\NoteWasAddedProjection; 
use Notepad\Infrastructure\Projection\NoteWasDeletedProjection; 
use Notepad\Infrastructure\Projection\UserWasAddedProjection; 
use Notepad\Infrastructure\Projection\NumUserNotesWasDecreasedProjection; 
use Notepad\Infrastructure\Projection\UsersNoteDeletedProjection; 
use Notepad\Infrastructure\Projection\NumUserNotesWasAddedProjection;
use Notepad\Infrastructure\Projection\NumUserNotesWasIncreasedProjection;
use Notepad\Infrastructure\Projection\NotepadWasAddedProjection; 
use Notepad\Infrastructure\Projection\NoteWasUpdatedProjection;
use Notepad\Infrastructure\Projection\UsersNoteAddedProjection; 
use Notepad\Infrastructure\Projection\UsersNoteUpdatedProjection;

use Notepad\Domain\Model\User\UserQueryRepository;
use Notepad\Domain\Model\Notepad\NotepadQueryRepository;

use Notepad\Infrastructure\Domain\Model\Notepad\DoctrineNotepadRepository;
use Notepad\Infrastructure\Domain\Model\User\DoctrineUserQueryRepository;

use Notepad\Infrastructure\Projection\DoctrineProjectedEventTracker;
use Notepad\Domain\Projection\ProjectedEventTracker;
use Notepad\Domain\Projection\ProjectedEvent;

use Notepad\Domain\Projection\ProjectorManager;




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
                            env('DB_USERNAME_PROJECTION'),
                            env('DB_PASSWORD_PROJECTION'));
                            
         $this->app->bind(UserRepository::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new DoctrineUserRepository(
                $em,
                $em->getClassMetaData(StoredEvent::class)
            );
        });

        $this->app->bind(UserQueryRepository::class, function($app)  use ($pdo){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new PDOUserRepository(
                $pdo
            );
        });

        $this->app->bind(NotepadRepository::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new DoctrineNotepadRepository(
                $em,
                $em->getClassMetaData(StoredEvent::class)
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
            return new DoctrineEventStoreRepository(
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
                                    new NoteWasDeletedProjection($pdo), 
                                    new NumUserNotesWasDecreasedProjection($pdo),
                                    new UsersNoteDeletedProjection($pdo),
                                    new UserWasAddedProjection($pdo),
                                    new NotepadWasAddedProjection($pdo),
                                    new NumUserNotesWasIncreasedProjection($pdo),
                                    new NumUserNotesWasAddedProjection($pdo),
                                    new UsersNoteAddedProjection($pdo),
                                    new NoteWasUpdatedProjection($pdo),
                                    new UsersNoteUpdatedProjection($pdo)
                                    ]);
            return $projector;
        });

        $this->app->bind(DomainEventSubscriber::class, function($app)  use ($em){
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new PersistDomainEventSubscriber(EventStore::class);
        });
    }
}
