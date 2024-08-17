<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817123300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step1 ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE step1 ADD CONSTRAINT FK_ACF02ACE4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_ACF02ACE4B89032C ON step1 (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step1 DROP FOREIGN KEY FK_ACF02ACE4B89032C');
        $this->addSql('DROP INDEX IDX_ACF02ACE4B89032C ON step1');
        $this->addSql('ALTER TABLE step1 DROP post_id');
    }
}
