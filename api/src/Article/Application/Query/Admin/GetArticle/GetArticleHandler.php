<?php

declare(strict_types=1);

namespace App\Article\Application\Query\Admin\GetArticle;

use App\Article\Application\Exception\Article\ArticleNotFoundByIdException;
use App\Article\Application\Query\Admin\GetArticle\View\ArticleView;
use App\Article\Infrastructure\Doctrine\ArticleRepository;

readonly class GetArticleHandler
{
    public function __construct(
        private ArticleRepository $articleRepository,
    ) {
    }

    /**
     * @throws ArticleNotFoundByIdException
     */
    public function handle(GetArticleQuery $query): ArticleView
    {
        $article = $this->articleRepository->find($query->id)
            ?? throw new ArticleNotFoundByIdException($query->id);

        return new ArticleView(
            (string)$article->getId(),
            (string)$article->getTitle(),
            (string)$article->getContent(),
        );
    }
}
