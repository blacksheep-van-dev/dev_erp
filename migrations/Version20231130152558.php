<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130152558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB08CDEADB2A');
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB083ADB05F1');
        $this->addSql('DROP INDEX IDX_72DDEB08CDEADB2A ON option_stock');
        $this->addSql('DROP INDEX IDX_72DDEB083ADB05F1 ON option_stock');
        $this->addSql('ALTER TABLE option_stock ADD option_id_id INT DEFAULT NULL, DROP options_id, DROP agency_id, DROP enabled, DROP price');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB0846AF233F FOREIGN KEY (option_id_id) REFERENCES `option` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_72DDEB0846AF233F ON option_stock (option_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_stock DROP FOREIGN KEY FK_72DDEB0846AF233F');
        $this->addSql('DROP INDEX UNIQ_72DDEB0846AF233F ON option_stock');
        $this->addSql('ALTER TABLE option_stock ADD agency_id INT DEFAULT NULL, ADD enabled TINYINT(1) NOT NULL, ADD price INT NOT NULL, CHANGE option_id_id options_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB08CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE option_stock ADD CONSTRAINT FK_72DDEB083ADB05F1 FOREIGN KEY (options_id) REFERENCES `option` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_72DDEB08CDEADB2A ON option_stock (agency_id)');
        $this->addSql('CREATE INDEX IDX_72DDEB083ADB05F1 ON option_stock (options_id)');
    }
}
