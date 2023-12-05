<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122135846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', label VARCHAR(255) NOT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', blind_return TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar_closed_days (id INT AUTO_INCREMENT NOT NULL, calendar_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_829B9608A40A2C8 (calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar_day (id INT AUTO_INCREMENT NOT NULL, calendar_id INT DEFAULT NULL, day VARCHAR(255) NOT NULL, open TINYINT(1) NOT NULL, INDEX IDX_1BC14B23A40A2C8 (calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar_hour (id INT AUTO_INCREMENT NOT NULL, day_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, open_from TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', open_to TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_2288921A9C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar_closed_days ADD CONSTRAINT FK_829B9608A40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE calendar_day ADD CONSTRAINT FK_1BC14B23A40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE calendar_hour ADD CONSTRAINT FK_2288921A9C24126 FOREIGN KEY (day_id) REFERENCES calendar_day (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar_closed_days DROP FOREIGN KEY FK_829B9608A40A2C8');
        $this->addSql('ALTER TABLE calendar_day DROP FOREIGN KEY FK_1BC14B23A40A2C8');
        $this->addSql('ALTER TABLE calendar_hour DROP FOREIGN KEY FK_2288921A9C24126');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE calendar_closed_days');
        $this->addSql('DROP TABLE calendar_day');
        $this->addSql('DROP TABLE calendar_hour');
    }
}
