<?php

namespace Notepad\Domain\Model\User;

interface UserRepository{
    public function add(User $user);
    public function ofId(UserId $userId);
    public function addNotepad(User $user);
    public function findAll();
    public function remove(User $user);
}