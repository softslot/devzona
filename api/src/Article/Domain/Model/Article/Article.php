<?php

declare(strict_types=1);

namespace App\Article\Domain\Model\Article;

use App\Article\Infrastructure\Doctrine\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: '`article_articles`')]
class Article
{
    #[ORM\Embedded(class: Id::class, columnPrefix: false)]
    private Id $id;

    #[ORM\Column(type: Types::STRING, length: 36, enumType: Status::class)]
    private Status $status;

    #[ORM\Embedded(class: Title::class, columnPrefix: false)]
    private Title $title;

    #[ORM\Embedded(class: Content::class, columnPrefix: false)]
    private Content $content;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(name: 'published_at', type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column(name: 'deleted_at', type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct(
        Id $id,
        Title $title,
        Content $content,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
        $this->status = Status::Draft;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): void
    {
        $this->title = $title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function setContent(Content $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
