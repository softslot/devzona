<?php

declare(strict_types = 1);

namespace App\Shared\Infrastructure\Http\Response;

class Violation implements \JsonSerializable
{
    public function __construct(
        public readonly string $property,
        public readonly string $message,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'property' => $this->property,
            'message' => $this->message,
        ];
    }
}
