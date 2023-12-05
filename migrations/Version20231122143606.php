<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122143606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', label VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, image VARCHAR(255) DEFAULT NULL, consumable TINYINT(1) NOT NULL, stock_control TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_product_category (option_id INT NOT NULL, product_category_id INT NOT NULL, INDEX IDX_7E0253C2A7C41D6F (option_id), INDEX IDX_7E0253C2BE6903FD (product_category_id), PRIMARY KEY(option_id, product_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_product_category ADD CONSTRAINT FK_7E0253C2A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_product_category ADD CONSTRAINT FK_7E0253C2BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_product_category DROP FOREIGN KEY FK_7E0253C2A7C41D6F');
        $this->addSql('ALTER TABLE option_product_category DROP FOREIGN KEY FK_7E0253C2BE6903FD');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_product_category');
    }
}
