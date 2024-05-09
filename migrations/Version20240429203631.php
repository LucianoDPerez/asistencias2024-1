<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429203631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technical_reports (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, content LONGTEXT NOT NULL, closed TINYINT(1) NOT NULL, response_time DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9D5302F4ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technical_reports ADD CONSTRAINT FK_9D5302F4ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service CHANGE service_type_id service_type_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technical_reports DROP FOREIGN KEY FK_9D5302F4ED5CA9E6');
        $this->addSql('DROP TABLE technical_reports');
        $this->addSql('ALTER TABLE service CHANGE service_type_id service_type_id INT NOT NULL');
    }
}
