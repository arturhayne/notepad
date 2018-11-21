<?php

namespace Notepad\Domain\Model\Notepad;

use Notepad\Domain\Model\User\UserId;

interface NotepadQueryRepository {
    public function getNotesFromUser(UserId $userId);
}