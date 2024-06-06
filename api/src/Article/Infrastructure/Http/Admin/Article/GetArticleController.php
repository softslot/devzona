<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Admin\Article;

use App\Article\Application\Exception\Article\ArticleNotFoundByIdException;
use App\Article\Application\Query\Admin\GetArticle\GetArticleHandler;
use App\Article\Application\Query\Admin\GetArticle\GetArticleQuery;
use App\Shared\Infrastructure\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetArticleController extends BaseController
{
    public function __construct(
        private readonly GetArticleHandler $getArticleHandler,
    ) {
    }

    public function execute(string $id): JsonResponse
    {
        $query = new GetArticleQuery($id);

        try {
            $articleView = $this->getArticleHandler->handle($query);
        } catch (ArticleNotFoundByIdException $e) {
            return $this->jsonError([
                'code' => 404,
                'message' => $e->getMessage(),
            ]);
        }

        return $this->jsonSuccess([
            'article' => $articleView,
        ]);
    }
}
