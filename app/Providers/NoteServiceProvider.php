<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Notepad\Domain\Model\NoteRepository;
use Notepad\Infrastructure\NotePDORepository;

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
        //$this->app->bind("Notepad\Domain\Model\NoteRepository", "Notepad\Infrastructure\EloquentNoteRepository");
        //sounds strange
        $this->app->bind(NoteRepository::class, function (Application $app) {
            return new NotePDORepository(
                new \PDO(
                    'pgsql:host=localhost;dbname=notepad',
                    'user',
                    'user'
                )
            );
         });
    }
}
