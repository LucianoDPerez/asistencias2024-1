<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429171757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, service_type_id INT NOT NULL, assigned_date DATETIME NOT NULL, assigned_time TIME NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(20) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_E19D9AD219EB6921 (client_id), INDEX IDX_E19D9AD2AC8DE0F (service_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2AC8DE0F FOREIGN KEY (service_type_id) REFERENCES service_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD219EB6921');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2AC8DE0F');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_type');
    }
}
