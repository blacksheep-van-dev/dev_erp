<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122141638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE price_list_price (id INT AUTO_INCREMENT NOT NULL, price_list_id INT DEFAULT NULL, price INT NOT NULL, minimal_duration INT NOT NULL, maximal_duration INT NOT NULL, INDEX IDX_A7D3B9DE5688DED7 (price_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_list_price ADD CONSTRAINT FK_A7D3B9DE5688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_list_price DROP FOREIGN KEY FK_A7D3B9DE5688DED7');
        $this->addSql('DROP TABLE price_list_price');
    }
}
