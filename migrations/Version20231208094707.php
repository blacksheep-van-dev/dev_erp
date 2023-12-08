<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208094707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agency_user (agency_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9A94CA41CDEADB2A (agency_id), INDEX IDX_9A94CA41A76ED395 (user_id), PRIMARY KEY(agency_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agency_user ADD CONSTRAINT FK_9A94CA41CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agency_user ADD CONSTRAINT FK_9A94CA41A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agency ADD type VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency_user DROP FOREIGN KEY FK_9A94CA41CDEADB2A');
        $this->addSql('ALTER TABLE agency_user DROP FOREIGN KEY FK_9A94CA41A76ED395');
        $this->addSql('DROP TABLE agency_user');
        $this->addSql('ALTER TABLE agency DROP type, DROP description');
    }
}
