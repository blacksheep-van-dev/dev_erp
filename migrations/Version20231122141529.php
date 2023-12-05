<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122141529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE price_list (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, product_category_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_399A0AA2CDEADB2A (agency_id), INDEX IDX_399A0AA2BE6903FD (product_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_list ADD CONSTRAINT FK_399A0AA2CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE price_list ADD CONSTRAINT FK_399A0AA2BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_list DROP FOREIGN KEY FK_399A0AA2CDEADB2A');
        $this->addSql('ALTER TABLE price_list DROP FOREIGN KEY FK_399A0AA2BE6903FD');
        $this->addSql('DROP TABLE price_list');
    }
}
