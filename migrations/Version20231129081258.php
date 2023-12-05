<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129081258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_product (booking_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_89F4418D3301C60 (booking_id), INDEX IDX_89F4418D4584665A (product_id), PRIMARY KEY(booking_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_activity (booking_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_974097D73301C60 (booking_id), INDEX IDX_974097D781C06096 (activity_id), PRIMARY KEY(booking_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_activity ADD CONSTRAINT FK_974097D73301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_activity ADD CONSTRAINT FK_974097D781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D3301C60');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D4584665A');
        $this->addSql('ALTER TABLE booking_activity DROP FOREIGN KEY FK_974097D73301C60');
        $this->addSql('ALTER TABLE booking_activity DROP FOREIGN KEY FK_974097D781C06096');
        $this->addSql('DROP TABLE booking_product');
        $this->addSql('DROP TABLE booking_activity');
    }
}
