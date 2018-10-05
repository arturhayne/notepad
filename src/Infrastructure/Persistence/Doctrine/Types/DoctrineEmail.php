<?php

namespace Notepad\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Notepad\Domain\Model\User\Email;

class DoctrineEmail extends GuidType
{
    public function getName()
    {
        return 'Email';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Email) {
            $value = (string) $value;
        }

        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Email::create($value);
    }
}