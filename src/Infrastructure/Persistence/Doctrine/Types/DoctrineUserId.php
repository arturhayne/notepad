<?php

namespace Notepad\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Notepad\Domain\Model\User\UserId;

class DoctrineUserId extends GuidType
{
    public function getName()
    {
        return 'UserId';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserdId) {
            $value = (string) $value;
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserId::createFromString($value);
    }
}