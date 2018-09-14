<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
          $this->app->bind("Notepad\Domain\Model\NoteRepository", "Notepad\Infrastructure\InMemoryNoteRepository");
          //$this->app->bind(NoteRepository::class, function (Application $app) {
          //  return new InMemoryNoteRepository();
         //});
    }
}
