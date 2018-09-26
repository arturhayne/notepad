<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use Notepad\Domain\Model\Note\NoteRepository;
use Notepad\Infrastructure\NotePDORepository;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Infrastructure\UserPDORepository;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Infrastructure\NotepadPDORepository;

use Notepad\Application\Service\Note\ArrayListNoteTransformer;
use Notepad\Application\Service\Note\ListNoteTransformer;

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


        $this->app->bind(NoteRepository::class, function (Application $app) {
            $pdo = new \PDO(env('STRING_CON'),
                            env('DB_USERNAME'),
                            env('DB_USERNAME'));
            return new NotePDORepository($pdo);
         });


         $this->app->bind(UserRepository::class, function (Application $app) {
            $pdo = new \PDO(env('STRING_CON'),
                            env('DB_USERNAME'),
                            env('DB_USERNAME'));
            return new UserPDORepository($pdo);
         });

         $this->app->bind(NotepadRepository::class, function (Application $app) {
            $pdo = new \PDO(env('STRING_CON'),
                            env('DB_USERNAME'),
                            env('DB_USERNAME'));
            return new NotepadPDORepository($pdo);
         });

         $this->app->bind(ListNoteTransformer::class, function (Application $app) {
            return new ArrayListNoteTransformer();
         });
    }
}
