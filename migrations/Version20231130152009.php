<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130152009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB0846AF233F');
        $this->addSql('DROP INDEX UNIQ_72DDEB0846AF233F ON option_stock');
        $this->addSql('ALTER TABLE option_stock CHANGE option_id_id options_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB083ADB05F1 FOREIGN KEY (options_id) REFERENCES `option` (id)');
        $this->addSql('CREATE INDEX IDX_72DDEB083ADB05F1 ON option_stock (options_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB083ADB05F1');
        $this->addSql('DROP INDEX IDX_72DDEB083ADB05F1 ON option_stock');
        $this->addSql('ALTER TABLE option_stock CHANGE options_id option_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB0846AF233F FOREIGN KEY (option_id_id) REFERENCES `option` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_72DDEB0846AF233F ON option_stock (option_id_id)');
    }
}
