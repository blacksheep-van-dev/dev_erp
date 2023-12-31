<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128145909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD vehicle_document_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D040541 FOREIGN KEY (vehicle_document_id) REFERENCES vehicle_document (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD4D040541 ON product (vehicle_document_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D040541');
        $this->addSql('DROP INDEX UNIQ_D34A04AD4D040541 ON product');
        $this->addSql('ALTER TABLE product DROP vehicle_document_id');
    }
}
