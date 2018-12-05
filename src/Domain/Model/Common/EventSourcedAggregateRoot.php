<?php

namespace Notepad\Domain\Model\Common;
use Notepad\Domain\Model\Common\AggregateHistory;


interface EventSourcedAggregateRoot{
    public static function reconstitute(AggregateHistory $events);
}