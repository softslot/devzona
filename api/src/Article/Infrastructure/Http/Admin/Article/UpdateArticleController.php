<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Admin\Article;

use App\Article\Application\Command\Admin\UpdateArticle\UpdateArticleCommand;
use App\Article\Application\Command\Admin\UpdateArticle\UpdateArticleHandler;
use App\Article\Application\Exception\Article\ArticleNotFoundByIdException;
use App\Shared\Infrastructure\Http\BaseController;
use App\Shared\Infrastructure\Http\Exception\BaseHttpException;
use App\Shared\Infrastructure\Http\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;

class UpdateArticleController extends BaseController
{
    public function __construct(
        private readonly UpdateArticleHandler $updateArticleHandler,
    ) {
    }

    /**
     * @throws BaseHttpException
     */
    public function execute(string $id, Request $request): void
    {
        $command = $this->createCommandFromRequest($request, UpdateArticleCommand::class, $id);

        try {
            $this->updateArticleHandler->handle($command);
        } catch (ArticleNotFoundByIdException $e) {
            throw new HttpException(404, $e->getMessage());
        }
    }
}
