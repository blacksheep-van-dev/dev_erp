<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122143339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item ADD product_id INT DEFAULT NULL, ADD activity_id INT DEFAULT NULL, ADD insurance_id INT DEFAULT NULL, ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking_item ADD CONSTRAINT FK_78A07504584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE booking_item ADD CONSTRAINT FK_78A075081C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE booking_item ADD CONSTRAINT FK_78A0750D1E63CD1 FOREIGN KEY (insurance_id) REFERENCES insurance (id)');
        $this->addSql('ALTER TABLE booking_item ADD CONSTRAINT FK_78A07503301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_78A07504584665A ON booking_item (product_id)');
        $this->addSql('CREATE INDEX IDX_78A075081C06096 ON booking_item (activity_id)');
        $this->addSql('CREATE INDEX IDX_78A0750D1E63CD1 ON booking_item (insurance_id)');
        $this->addSql('CREATE INDEX IDX_78A07503301C60 ON booking_item (booking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_item DROP FOREIGN KEY FK_78A07504584665A');
        $this->addSql('ALTER TABLE booking_item DROP FOREIGN KEY FK_78A075081C06096');
        $this->addSql('ALTER TABLE booking_item DROP FOREIGN KEY FK_78A0750D1E63CD1');
        $this->addSql('ALTER TABLE booking_item DROP FOREIGN KEY FK_78A07503301C60');
        $this->addSql('DROP INDEX IDX_78A07504584665A ON booking_item');
        $this->addSql('DROP INDEX IDX_78A075081C06096 ON booking_item');
        $this->addSql('DROP INDEX IDX_78A0750D1E63CD1 ON booking_item');
        $this->addSql('DROP INDEX IDX_78A07503301C60 ON booking_item');
        $this->addSql('ALTER TABLE booking_item DROP product_id, DROP activity_id, DROP insurance_id, DROP booking_id');
    }
}
