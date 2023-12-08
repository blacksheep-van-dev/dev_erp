<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207145035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD booking_item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A48D1177E FOREIGN KEY (booking_item_id) REFERENCES booking_item (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A48D1177E ON activity (booking_item_id)');
        $this->addSql('ALTER TABLE product_category ADD agency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('CREATE INDEX IDX_CDFC7356CDEADB2A ON product_category (agency_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A48D1177E');
        $this->addSql('DROP INDEX IDX_AC74095A48D1177E ON activity');
        $this->addSql('ALTER TABLE activity DROP booking_item_id');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356CDEADB2A');
        $this->addSql('DROP INDEX IDX_CDFC7356CDEADB2A ON product_category');
        $this->addSql('ALTER TABLE product_category DROP agency_id');
    }
}
