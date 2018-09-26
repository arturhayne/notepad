<?php

namespace Domain;

interface DomainEvent {
    /**  @return \DateTimeImmutable */
    public function occurredOn ();
}