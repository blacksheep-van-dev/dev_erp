<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201143037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item_option DROP FOREIGN KEY FK_FBE4AEB63ADB05F1');
        $this->addSql('DROP INDEX IDX_FBE4AEB63ADB05F1 ON booking_item_option');
        $this->addSql('ALTER TABLE booking_item_option CHANGE options_id option_stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking_item_option ADD CONSTRAINT FK_FBE4AEB62DBA10B4 FOREIGN KEY (option_stock_id) REFERENCES option_stock (id)');
        $this->addSql('CREATE INDEX IDX_FBE4AEB62DBA10B4 ON booking_item_option (option_stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item_option DROP FOREIGN KEY FK_FBE4AEB62DBA10B4');
        $this->addSql('DROP INDEX IDX_FBE4AEB62DBA10B4 ON booking_item_option');
        $this->addSql('ALTER TABLE booking_item_option CHANGE option_stock_id options_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking_item_option ADD CONSTRAINT FK_FBE4AEB63ADB05F1 FOREIGN KEY (options_id) REFERENCES `option` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FBE4AEB63ADB05F1 ON booking_item_option (options_id)');
    }
}
