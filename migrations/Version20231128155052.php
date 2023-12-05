<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128155052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item_option DROP INDEX UNIQ_FBE4AEB63ADB05F1, ADD INDEX IDX_FBE4AEB63ADB05F1 (options_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item_option DROP INDEX IDX_FBE4AEB63ADB05F1, ADD UNIQUE INDEX UNIQ_FBE4AEB63ADB05F1 (options_id)');
    }
}
