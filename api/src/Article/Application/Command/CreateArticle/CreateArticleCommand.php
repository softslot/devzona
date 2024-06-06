<?php

declare(strict_types=1);

namespace App\Article\Application\Command\CreateArticle;

class CreateArticleCommand
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
    ) {
    }
}
