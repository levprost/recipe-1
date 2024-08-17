<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817140447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_has_ingredient ADD unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_has_ingredient ADD CONSTRAINT FK_94CB183F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_94CB183F8BD700D ON post_has_ingredient (unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_has_ingredient DROP FOREIGN KEY FK_94CB183F8BD700D');
        $this->addSql('DROP INDEX IDX_94CB183F8BD700D ON post_has_ingredient');
        $this->addSql('ALTER TABLE post_has_ingredient DROP unit_id');
    }
}
