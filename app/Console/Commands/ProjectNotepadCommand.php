<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Notepad\Application\Service\Notification\ProjectionService;
use Notepad\Domain\Notification\ProjectedEventTracker;
use Notepad\Domain\Notification\ProjectorManager;
use Notepad\Domain\Model\EventStore\EventStore;


class ProjectNotepadCommand extends Command
{
    protected $eventStore;
    protected $eventTracker;
    protected $projectorManager;
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
    public function __construct(EventStore $eventStore,
            ProjectedEventTracker $eventTracker,
            ProjectorManager $projectorManager)
    {
        $this->eventStore = $eventStore;
        $this->eventTracker = $eventTracker;
        $this->projectorManager = $projectorManager;
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

        $projectionService = new ProjectionService(
            $this->eventStore,
            $this->eventTracker,
            $this->projectorManager
        );

        $numberOfNotifications = $projectionService->projectEvents($exchangeName);
        $this->info($numberOfNotifications.' event(s) sent! ');
    }
}
