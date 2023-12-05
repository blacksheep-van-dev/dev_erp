<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122150921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_stock (id INT AUTO_INCREMENT NOT NULL, option_id_id INT DEFAULT NULL, agency_id INT DEFAULT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_72DDEB0846AF233F (option_id_id), INDEX IDX_72DDEB08CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB0846AF233F FOREIGN KEY (option_id_id) REFERENCES `option` (id)');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB08CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB0846AF233F');
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB08CDEADB2A');
        $this->addSql('DROP TABLE option_stock');
    }
}
