<?php

declare(strict_types=1);

namespace App\Article\Application\Command\Admin\UpdateArticle;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateArticleCommand
{
    public function __construct(
        public string $id,
        public ?string $title = null,
        public ?string $content = null,
    ) {
    }
}
