<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Admin\Article;

use App\Article\Application\Exception\Article\ArticleNotFoundByIdException;
use App\Article\Application\Query\Admin\GetArticle\GetArticleHandler;
use App\Article\Application\Query\Admin\GetArticle\GetArticleQuery;
use App\Shared\Infrastructure\Http\BaseController;
use App\Shared\Infrastructure\Http\Exception\BaseHttpException;
use App\Shared\Infrastructure\Http\Exception\HttpException;

final class GetArticleController extends BaseController
{
    public function __construct(
        private readonly GetArticleHandler $getArticleHandler,
    ) {
    }

    /**
     * @throws BaseHttpException
     */
    public function execute(string $id): array
    {
        $query = new GetArticleQuery($id);

        try {
            $articleView = $this->getArticleHandler->handle($query);
        } catch (ArticleNotFoundByIdException $e) {
            return throw new HttpException(404, $e->getMessage());
        }

        return [
            'article' => $articleView,
        ];
    }
}
