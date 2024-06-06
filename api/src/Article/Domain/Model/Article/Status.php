<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Article;

use Doctrine\ORM\Mapping as ORM;

enum Status: string
{
    case Draft = 'draft';
}
