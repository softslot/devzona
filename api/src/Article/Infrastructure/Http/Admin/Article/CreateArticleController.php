<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Admin\Article;

use App\Article\Application\Command\Admin\CreateArticle\CreateArticleCommand;
use App\Article\Application\Command\Admin\CreateArticle\CreateArticleHandler;
use App\Shared\Infrastructure\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateArticleController extends BaseController
{
    public function __construct(
        private readonly CreateArticleHandler $createArticleHandler,
    ) {
    }

    public function execute(Request $request): JsonResponse
    {
        $command = $this->createCommandFromRequest($request, CreateArticleCommand::class);
        $this->createArticleHandler->handle($command);

        return $this->jsonSuccess([
            'id' => $command->id,
        ]);
    }
}
