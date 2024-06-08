<?php

declare(strict_types = 1);

namespace App\Shared\Infrastructure\Http\Response;

class ErrorsBag
{
    /**
     * @var Error[]
     */
    protected array $errors = [];

    /**
     * @var Violation[]
     */
    protected array $violations = [];


    public function addError(Error $error): ErrorsBag
    {
        $this->errors[] = $error;

        return $this;
    }

    public function addFrontError(int $status = 0, ?string $title = null, ?string $message = null): ErrorsBag
    {
        return $this->addError(new Error($status, $title, $message));
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return Error[]
     */
    public function jsonSerialize(): array
    {
        return $this->getErrors();
    }

    public function addViolation(Violation $violation): ErrorsBag
    {
        $this->violations[] = $violation;

        return $this;
    }

    /**
     * @return Violation[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
