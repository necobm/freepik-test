<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502222103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creatures DROP FOREIGN KEY FK_A1F49564B50E85D1');
        $this->addSql('ALTER TABLE creatures DROP FOREIGN KEY FK_A1F49564A9C670A');
        $this->addSql('DROP INDEX IDX_A1F49564A9C670A ON creatures');
        $this->addSql('DROP INDEX IDX_A1F49564B50E85D1 ON creatures');
        $this->addSql('ALTER TABLE creatures ADD weapon_id INT DEFAULT NULL, DROP main_weapon_id, DROP secondary_weapon_id');
        $this->addSql('ALTER TABLE creatures ADD CONSTRAINT FK_A1F4956495B82273 FOREIGN KEY (weapon_id) REFERENCES weapons (id)');
        $this->addSql('CREATE INDEX IDX_A1F4956495B82273 ON creatures (weapon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creatures DROP FOREIGN KEY FK_A1F4956495B82273');
        $this->addSql('DROP INDEX IDX_A1F4956495B82273 ON creatures');
        $this->addSql('ALTER TABLE creatures ADD secondary_weapon_id INT DEFAULT NULL, CHANGE weapon_id main_weapon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creatures ADD CONSTRAINT FK_A1F49564B50E85D1 FOREIGN KEY (main_weapon_id) REFERENCES weapons (id)');
        $this->addSql('ALTER TABLE creatures ADD CONSTRAINT FK_A1F49564A9C670A FOREIGN KEY (secondary_weapon_id) REFERENCES weapons (id)');
        $this->addSql('CREATE INDEX IDX_A1F49564A9C670A ON creatures (secondary_weapon_id)');
        $this->addSql('CREATE INDEX IDX_A1F49564B50E85D1 ON creatures (main_weapon_id)');
    }
}
