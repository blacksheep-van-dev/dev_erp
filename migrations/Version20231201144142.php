<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201144142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_activity DROP FOREIGN KEY FK_974097D781C06096');
        $this->addSql('ALTER TABLE booking_activity DROP FOREIGN KEY FK_974097D73301C60');
        $this->addSql('ALTER TABLE booking_product_category DROP FOREIGN KEY FK_F32F2210BE6903FD');
        $this->addSql('ALTER TABLE booking_product_category DROP FOREIGN KEY FK_F32F22103301C60');
        $this->addSql('DROP TABLE booking_activity');
        $this->addSql('DROP TABLE booking_product_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_activity (booking_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_974097D73301C60 (booking_id), INDEX IDX_974097D781C06096 (activity_id), PRIMARY KEY(booking_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE booking_product_category (booking_id INT NOT NULL, product_category_id INT NOT NULL, INDEX IDX_F32F2210BE6903FD (product_category_id), INDEX IDX_F32F22103301C60 (booking_id), PRIMARY KEY(booking_id, product_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE booking_activity ADD CONSTRAINT FK_974097D781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_activity ADD CONSTRAINT FK_974097D73301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product_category ADD CONSTRAINT FK_F32F2210BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product_category ADD CONSTRAINT FK_F32F22103301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
