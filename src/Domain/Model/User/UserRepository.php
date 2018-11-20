<?php

namespace Notepad\Domain\Model\User;

interface UserRepository{
    public function add(User $user);
    public function ofId(UserId $userId);
    public function findAll();
}