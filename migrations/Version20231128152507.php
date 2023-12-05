<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128152507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_category ADD agency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('CREATE INDEX IDX_CDFC7356CDEADB2A ON product_category (agency_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356CDEADB2A');
        $this->addSql('DROP INDEX IDX_CDFC7356CDEADB2A ON product_category');
        $this->addSql('ALTER TABLE product_category DROP agency_id');
    }
}
