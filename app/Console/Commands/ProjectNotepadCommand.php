<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Notepad\Application\Service\Projection\ProjectionService;


class ProjectNotepadCommand extends Command
{
    protected $projectionService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:events:spread {exchange-name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all domain events via messaging';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProjectionService $projectionService)
    {   $this->projectionService = $projectionService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $exchangeName = $this->argument('exchange-name');
        $numberOfNotifications = $this->projectionService->projectEvents($exchangeName);
        $this->info($numberOfNotifications.' event(s) sent! ');
    }
}
