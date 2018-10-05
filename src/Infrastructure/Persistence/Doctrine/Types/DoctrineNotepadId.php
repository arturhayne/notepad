<?php

namespace Notepad\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Notepad\Domain\Model\Notepad\NotepadId;

class DoctrineNotepadId extends GuidType
{
    public function getName()
    {
        return 'NotepadId';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof NotepadId) {
            $value = (string) $value;
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return NotepadId::createFromString($value);
    }
}