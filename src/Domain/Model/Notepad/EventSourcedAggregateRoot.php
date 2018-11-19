<?php

namespace Notepad\Domain\Model\Notepad;

interface EventSourcedAggregateRoot{


    public static function reconstitute(EventStream $events);

}