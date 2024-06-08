<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exception;

class IncorrectTypesException extends BaseHttpException
{
    public function __construct(int $code, string $path, string $currentType, array $expectedTypes)
    {
        $types = implode(', ', $expectedTypes);
        parent::__construct("The type of the '{$path}' attribute must be one of '$types' ('{$currentType}' given).", $code);
    }
}
