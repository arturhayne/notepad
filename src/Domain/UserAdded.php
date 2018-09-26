<?php

namespace Domain;

class UserAdded implements DomainEvent {

    public function occurredOn(){
        return $this->occurredOn;
    }

}