<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122101625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_model ADD brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brand_model ADD CONSTRAINT FK_8C6CBBCE44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_8C6CBBCE44F5D008 ON brand_model (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_model DROP FOREIGN KEY FK_8C6CBBCE44F5D008');
        $this->addSql('DROP INDEX IDX_8C6CBBCE44F5D008 ON brand_model');
        $this->addSql('ALTER TABLE brand_model DROP brand_id');
    }
}
