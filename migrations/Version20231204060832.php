<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204060832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_option_stock (booking_id INT NOT NULL, option_stock_id INT NOT NULL, INDEX IDX_90420AC73301C60 (booking_id), INDEX IDX_90420AC72DBA10B4 (option_stock_id), PRIMARY KEY(booking_id, option_stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_option_stock ADD CONSTRAINT FK_90420AC73301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_option_stock ADD CONSTRAINT FK_90420AC72DBA10B4 FOREIGN KEY (option_stock_id) REFERENCES option_stock (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_option_stock DROP FOREIGN KEY FK_90420AC73301C60');
        $this->addSql('ALTER TABLE booking_option_stock DROP FOREIGN KEY FK_90420AC72DBA10B4');
        $this->addSql('DROP TABLE booking_option_stock');
    }
}
