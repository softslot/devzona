<?php

declare(strict_types=1);

namespace App\Article\Application\Exception\Article;

use App\Article\Application\Exception\BaseApplicationException;

class ArticleNotFoundByIdException extends BaseApplicationException
{
    public function __construct(string $id)
    {
        parent::__construct("Article not found by id: {$id}");
    }
}
