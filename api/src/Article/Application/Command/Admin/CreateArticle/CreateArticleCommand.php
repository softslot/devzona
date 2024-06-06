<?php

declare(strict_types=1);

namespace App\Article\Application\Command\Admin\CreateArticle;

readonly class CreateArticleCommand
{
    public function __construct(
        public string $id,
        public string $title,
        public string $content,
    ) {
    }
}
