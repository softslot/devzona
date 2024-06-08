<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exception;

class ValidationPropertiesException extends BaseHttpException
{
    private array $violations = [];

    public function __construct(int $code, array $violations)
    {
        $this->violations = $violations;
        parent::__construct('Validation error', $code);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
