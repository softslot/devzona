<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Article;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Title implements \Stringable
{
    #[ORM\Column(
        name: 'title',
        type: Types::STRING,
        length: 255,
        nullable: false,
    )]
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
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
}
