<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429211836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technical_reports ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE technical_reports ADD CONSTRAINT FK_9D5302F4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9D5302F4A76ED395 ON technical_reports (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technical_reports DROP FOREIGN KEY FK_9D5302F4A76ED395');
        $this->addSql('DROP INDEX IDX_9D5302F4A76ED395 ON technical_reports');
        $this->addSql('ALTER TABLE technical_reports DROP user_id');
    }
}
