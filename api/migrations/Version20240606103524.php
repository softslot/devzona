<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240606103524 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "article_articles" (id UUID NOT NULL, status VARCHAR(36) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "article_articles".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "article_articles".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "article_articles".published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "article_articles".deleted_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE "article_articles"');
    }
}
