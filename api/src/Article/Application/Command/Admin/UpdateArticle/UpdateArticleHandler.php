<?php

declare(strict_types=1);

namespace App\Article\Application\Command\Admin\UpdateArticle;

use App\Article\Application\Exception\Article\ArticleNotFoundByIdException;
use App\Article\Domain\Model\Article\Content;
use App\Article\Domain\Model\Article\Title;
use App\Article\Infrastructure\Doctrine\ArticleRepository;
use App\Shared\Infrastructure\Doctrine\AppEntityManager;

readonly class UpdateArticleHandler
{
    public function __construct(
        private ArticleRepository $articleRepository,
        private AppEntityManager $appEntityManager,
    ) {
    }

    /**
     * @throws ArticleNotFoundByIdException
     */
    public function handle(UpdateArticleCommand $command): void
    {
        $article = $this->articleRepository->find($command->id)
            ?? throw new ArticleNotFoundByIdException($command->id);

        $article->update(
            $command->title ? new Title($command->title) : null,
            $command->content ? new Content($command->content) : null,
        );

        $this->appEntityManager->save($article);
    }
}
