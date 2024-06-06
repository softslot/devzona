<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Article;

use App\Article\Domain\Model\Article\Article;
use App\Article\Domain\Model\Article\Content;
use App\Article\Domain\Model\Article\Id;
use App\Article\Domain\Model\Article\Title;
use App\Shared\Infrastructure\Doctrine\AppEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateArticleController extends AbstractController
{
    public function __construct(
        private readonly AppEntityManager $appEntityManager,
    ) {
    }

    public function execute(): JsonResponse
    {
        $article = new Article(
            $id = Id::generate(),
            new Title('title'),
            new Content('content'),
        );

        $this->appEntityManager->save($article);

        return $this->json([
            'message' => "Article created, id: {$id}.",
        ]);
    }
}
