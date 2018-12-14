<?php

namespace Notepad\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Notepad\Domain\Model\Notepad\NoteId;

class DoctrineNoteId extends GuidType
{
    public function getName()
    {
        return 'NoteId';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof NoteId) {
            $value = (string) $value;
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return NoteId::createFromString($value);
    }
}