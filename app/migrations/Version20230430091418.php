<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430091418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creatures (id INT AUTO_INCREMENT NOT NULL, faction_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, age INT NOT NULL, main_weapon VARCHAR(255) DEFAULT NULL, secondary_weapon VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A1F495645E237E06 (name), INDEX IDX_A1F495644448F8DA (faction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_creature (id INT AUTO_INCREMENT NOT NULL, mission_id INT DEFAULT NULL, creature_id INT DEFAULT NULL, is_leader TINYINT(1) NOT NULL, INDEX IDX_22906B4DBE6CAE90 (mission_id), INDEX IDX_22906B4DF9AB048 (creature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, description TEXT NOT NULL, difficulty INT NOT NULL, finished TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, portability INT NOT NULL, damage INT NOT NULL, resistance INT NOT NULL, UNIQUE INDEX UNIQ_520EBBE15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creatures ADD CONSTRAINT FK_A1F495644448F8DA FOREIGN KEY (faction_id) REFERENCES factions (id)');
        $this->addSql('ALTER TABLE mission_creature ADD CONSTRAINT FK_22906B4DBE6CAE90 FOREIGN KEY (mission_id) REFERENCES missions (id)');
        $this->addSql('ALTER TABLE mission_creature ADD CONSTRAINT FK_22906B4DF9AB048 FOREIGN KEY (creature_id) REFERENCES creatures (id)');
        $this->addSql('ALTER TABLE factions ADD leader_id INT DEFAULT NULL, DROP leader');
        $this->addSql('ALTER TABLE factions ADD CONSTRAINT FK_EB8258C473154ED4 FOREIGN KEY (leader_id) REFERENCES creatures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB8258C473154ED4 ON factions (leader_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factions DROP FOREIGN KEY FK_EB8258C473154ED4');
        $this->addSql('ALTER TABLE creatures DROP FOREIGN KEY FK_A1F495644448F8DA');
        $this->addSql('ALTER TABLE mission_creature DROP FOREIGN KEY FK_22906B4DBE6CAE90');
        $this->addSql('ALTER TABLE mission_creature DROP FOREIGN KEY FK_22906B4DF9AB048');
        $this->addSql('DROP TABLE creatures');
        $this->addSql('DROP TABLE mission_creature');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE weapons');
        $this->addSql('DROP INDEX UNIQ_EB8258C473154ED4 ON factions');
        $this->addSql('ALTER TABLE factions ADD leader TEXT NOT NULL, DROP leader_id');
    }
}
