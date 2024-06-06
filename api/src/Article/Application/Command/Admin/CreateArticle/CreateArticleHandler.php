<?php

declare(strict_types=1);

namespace App\Article\Application\Command\Admin\CreateArticle;

use App\Article\Domain\Model\Article\Article;
use App\Article\Domain\Model\Article\Content;
use App\Article\Domain\Model\Article\Id;
use App\Article\Domain\Model\Article\Title;
use App\Shared\Infrastructure\Doctrine\AppEntityManager;

final readonly class CreateArticleHandler
{
    public function __construct(
        private AppEntityManager $appEntityManager,
    ) {
    }

    public function handle(CreateArticleCommand $command): void
    {
        $article = new Article(
            new Id($command->id),
            new Title($command->title),
            new Content($command->content),
        );

        $this->appEntityManager->save($article);
    }
}
