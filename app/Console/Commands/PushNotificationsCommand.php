<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Notepad\Application\Service\Notification\NotificationService;
use Notepad\Domain\Notification\PublishedMessageTracker;
use Notepad\Domain\Notification\MessageProducer;
use Notepad\Domain\Model\EventStore\EventStore;


class PushNotificationsCommand extends Command
{
    protected $eventStore;
    protected $messageTracker;
    protected $messageProducer;
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
            PublishedMessageTracker $messageTracker,
            MessageProducer $messageProducer)
    {
        $this->eventStore = $eventStore;
        $this->messageTracker = $messageTracker;
        $this->messageProducer = $messageProducer;
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

        $notificationService = new NotificationService(
            $this->eventStore,
            $this->messageTracker,
            $this->messageProducer
        );

        $numberOfNotifications = $notificationService->publishNotifications($exchangeName);
        $this->info($numberOfNotifications.' notification(s) sent!');
    }
}
