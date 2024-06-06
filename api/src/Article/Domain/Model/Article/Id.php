<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Article;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Id implements \Stringable
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::GUID)]
    private string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->getValue();
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid7()->toString());
    }
}
