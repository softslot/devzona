<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\Exception;

class HttpException extends BaseHttpException
{
    public function __construct(int $code, string $message)
    {
        parent::__construct($message, $code);
    }
}
