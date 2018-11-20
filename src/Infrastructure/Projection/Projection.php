<?php

namespace Notepad\Infrastructure\Projection;


interface Projection{
    public function listenTo();
    public function project($event);
}