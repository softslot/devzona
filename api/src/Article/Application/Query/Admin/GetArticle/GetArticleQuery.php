<?php

declare(strict_types=1);

namespace App\Article\Application\Query\Admin\GetArticle;

final readonly class GetArticleQuery
{
    public function __construct(
        public string $id,
    ) {
    }
}
