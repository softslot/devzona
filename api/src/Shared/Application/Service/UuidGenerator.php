<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    public static function generate(): string
    {
        return Uuid::uuid7()->toString();
    }
}
