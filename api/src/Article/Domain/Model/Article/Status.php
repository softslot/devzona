<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Article;

enum Status: string
{
    case Draft = 'draft';
}
