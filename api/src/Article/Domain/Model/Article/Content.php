<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Article;

use Doctrine\DBAL\Types\Types;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class Content implements \Stringable
{
    #[ORM\Column(name: 'content', type: Types::TEXT)]
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
