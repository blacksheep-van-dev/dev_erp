<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130150311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock ADD agency_id INT DEFAULT NULL, ADD enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB08CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('CREATE INDEX IDX_72DDEB08CDEADB2A ON option_stock (agency_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB08CDEADB2A');
        $this->addSql('DROP INDEX IDX_72DDEB08CDEADB2A ON option_stock');
        $this->addSql('ALTER TABLE option_stock DROP agency_id, DROP enabled');
    }
}
