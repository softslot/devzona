<?php

declare(strict_types = 1);

namespace App\Shared\Infrastructure\Http\Response;

class ResponseBody implements \JsonSerializable
{
    private mixed $body = null;

    private ErrorsBag $errorBag;

    public function __construct(ErrorsBag $errorBag)
    {
        $this->errorBag = $errorBag;
    }

    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getErrorBag(): ErrorsBag
    {
        return $this->errorBag;
    }

    public function setErrorBag(ErrorsBag $errorBag): self
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return [
            'success' => count($this->getErrorBag()->getErrors()) === 0 && count($this->getErrorBag()->getViolations()) === 0,
            'errors' => $this->getErrorBag()->getErrors(),
            'violations' => $this->getErrorBag()->getViolations(),
            'body' => $this->getBody()
        ];
    }
}
