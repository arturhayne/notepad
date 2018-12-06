<?php

namespace Notepad\Domain\Model\User;

interface UserRepository{
    public function ofId(UserId $userId);
}