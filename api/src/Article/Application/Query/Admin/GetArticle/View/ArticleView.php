<?php

declare(strict_types=1);

namespace App\Article\Application\Query\Admin\GetArticle\View;

final readonly class ArticleView
{
    public function __construct(
        public string $id,
        public string $title,
        public string $content,
    ) {
    }
}
