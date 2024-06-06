<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240606112556 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article_articles ALTER published_at DROP NOT NULL');
        $this->addSql('ALTER TABLE article_articles ALTER deleted_at DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "article_articles" ALTER published_at SET NOT NULL');
        $this->addSql('ALTER TABLE "article_articles" ALTER deleted_at SET NOT NULL');
    }
}
