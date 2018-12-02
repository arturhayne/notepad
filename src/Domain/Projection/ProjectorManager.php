<?php

namespace Notepad\Domain\Projection;

interface ProjectorManager
{
    public function projectEvent($type, $event);
}
