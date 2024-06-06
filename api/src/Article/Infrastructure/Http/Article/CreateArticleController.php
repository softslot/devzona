<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Http\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateArticleController extends AbstractController
{
    public function execute(): JsonResponse
    {
        return $this->json([
            'message' => 'Article created.',
        ]);
    }
}
