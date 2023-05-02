<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502175621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission_creature DROP FOREIGN KEY FK_22906B4DBE6CAE90');
        $this->addSql('ALTER TABLE mission_creature DROP FOREIGN KEY FK_22906B4DF9AB048');
        $this->addSql('DROP TABLE mission_creature');
        $this->addSql('ALTER TABLE creatures ADD mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creatures ADD CONSTRAINT FK_A1F49564BE6CAE90 FOREIGN KEY (mission_id) REFERENCES missions (id)');
        $this->addSql('CREATE INDEX IDX_A1F49564BE6CAE90 ON creatures (mission_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_creature (id INT AUTO_INCREMENT NOT NULL, mission_id INT DEFAULT NULL, creature_id INT DEFAULT NULL, is_leader TINYINT(1) NOT NULL, INDEX IDX_22906B4DF9AB048 (creature_id), INDEX IDX_22906B4DBE6CAE90 (mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mission_creature ADD CONSTRAINT FK_22906B4DBE6CAE90 FOREIGN KEY (mission_id) REFERENCES missions (id)');
        $this->addSql('ALTER TABLE mission_creature ADD CONSTRAINT FK_22906B4DF9AB048 FOREIGN KEY (creature_id) REFERENCES creatures (id)');
        $this->addSql('ALTER TABLE creatures DROP FOREIGN KEY FK_A1F49564BE6CAE90');
        $this->addSql('DROP INDEX IDX_A1F49564BE6CAE90 ON creatures');
        $this->addSql('ALTER TABLE creatures DROP mission_id');
    }
}
