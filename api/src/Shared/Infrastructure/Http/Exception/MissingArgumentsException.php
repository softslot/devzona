<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exception;

class MissingArgumentsException extends BaseHttpException
{
    public function __construct(int $code, array $missingArguments)
    {
        $arguments = implode(', ', $missingArguments);
        parent::__construct("Missing arguments: {$arguments}", $code);
    }
}
