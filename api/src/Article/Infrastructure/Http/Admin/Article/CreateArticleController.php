<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Admin\Article;

use App\Article\Application\Command\Admin\CreateArticle\CreateArticleCommand;
use App\Article\Application\Command\Admin\CreateArticle\CreateArticleHandler;
use App\Shared\Infrastructure\Http\BaseController;
use App\Shared\Infrastructure\Http\Exception\BaseHttpException;
use Symfony\Component\HttpFoundation\Request;

final class CreateArticleController extends BaseController
{
    public function __construct(
        private readonly CreateArticleHandler $createArticleHandler,
    ) {
    }

    /**
     * @throws BaseHttpException
     */
    public function execute(Request $request): array
    {
        $command = $this->createCommandFromRequest($request, CreateArticleCommand::class);
        $this->createArticleHandler->handle($command);

        return [
            'id' => $command->id,
        ];
    }
}
