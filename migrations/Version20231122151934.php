<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122151934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_item_option (id INT AUTO_INCREMENT NOT NULL, booking_item_id INT DEFAULT NULL, options_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', price INT NOT NULL, quantity INT NOT NULL, INDEX IDX_FBE4AEB648D1177E (booking_item_id), UNIQUE INDEX UNIQ_FBE4AEB63ADB05F1 (options_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_item_option ADD CONSTRAINT FK_FBE4AEB648D1177E FOREIGN KEY (booking_item_id) REFERENCES booking_item (id)');
        $this->addSql('ALTER TABLE booking_item_option ADD CONSTRAINT FK_FBE4AEB63ADB05F1 FOREIGN KEY (options_id) REFERENCES `option` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item_option DROP FOREIGN KEY FK_FBE4AEB648D1177E');
        $this->addSql('ALTER TABLE booking_item_option DROP FOREIGN KEY FK_FBE4AEB63ADB05F1');
        $this->addSql('DROP TABLE booking_item_option');
    }
}
