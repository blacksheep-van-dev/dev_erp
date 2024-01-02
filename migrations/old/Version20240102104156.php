<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102104156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C52F958EA750E8 ON brand (label)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C6CBBCEEA750E8 ON brand_model (label)');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1C52F958EA750E8 ON brand');
        $this->addSql('DROP INDEX UNIQ_8C6CBBCEEA750E8 ON brand_model');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }
}