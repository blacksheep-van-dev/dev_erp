<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211101207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, num_street VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_agency (address_id INT NOT NULL, agency_id INT NOT NULL, INDEX IDX_4B994359F5B7AF75 (address_id), INDEX IDX_4B994359CDEADB2A (agency_id), PRIMARY KEY(address_id, agency_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_company (address_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_145AFED7F5B7AF75 (address_id), INDEX IDX_145AFED7979B1AD6 (company_id), PRIMARY KEY(address_id, company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_user (address_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F0DF06A2F5B7AF75 (address_id), INDEX IDX_F0DF06A2A76ED395 (user_id), PRIMARY KEY(address_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_product (booking_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_89F4418D3301C60 (booking_id), INDEX IDX_89F4418D4584665A (product_id), PRIMARY KEY(booking_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address_agency ADD CONSTRAINT FK_4B994359F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_agency ADD CONSTRAINT FK_4B994359CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_company ADD CONSTRAINT FK_145AFED7F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_company ADD CONSTRAINT FK_145AFED7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_user ADD CONSTRAINT FK_F0DF06A2F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_user ADD CONSTRAINT FK_F0DF06A2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_agency DROP FOREIGN KEY FK_4B994359F5B7AF75');
        $this->addSql('ALTER TABLE address_agency DROP FOREIGN KEY FK_4B994359CDEADB2A');
        $this->addSql('ALTER TABLE address_company DROP FOREIGN KEY FK_145AFED7F5B7AF75');
        $this->addSql('ALTER TABLE address_company DROP FOREIGN KEY FK_145AFED7979B1AD6');
        $this->addSql('ALTER TABLE address_user DROP FOREIGN KEY FK_F0DF06A2F5B7AF75');
        $this->addSql('ALTER TABLE address_user DROP FOREIGN KEY FK_F0DF06A2A76ED395');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D3301C60');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D4584665A');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE address_agency');
        $this->addSql('DROP TABLE address_company');
        $this->addSql('DROP TABLE address_user');
        $this->addSql('DROP TABLE booking_product');
    }
}
