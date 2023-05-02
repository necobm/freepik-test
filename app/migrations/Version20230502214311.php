<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502214311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creatures ADD is_faction_leader TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE factions DROP FOREIGN KEY FK_EB8258C473154ED4');
        $this->addSql('DROP INDEX UNIQ_EB8258C473154ED4 ON factions');
        $this->addSql('ALTER TABLE factions DROP leader_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creatures DROP is_faction_leader');
        $this->addSql('ALTER TABLE factions ADD leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE factions ADD CONSTRAINT FK_EB8258C473154ED4 FOREIGN KEY (leader_id) REFERENCES creatures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB8258C473154ED4 ON factions (leader_id)');
    }
}
