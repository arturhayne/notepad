<?php

namespace Notepad\Domain\Model\User;

interface UserRepository{
    public function add(User $user);
    public function remove(UserId $userId);
    public function getAll();
    public function ofId(UserId $userId);
    public function addNotepad(User $user);
    public function getAllNotepads(UserId $userId);
}