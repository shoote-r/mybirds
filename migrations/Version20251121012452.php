<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251121012452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE birds ADD COLUMN image_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__birds AS SELECT id, garden_id, name, description FROM birds');
        $this->addSql('DROP TABLE birds');
        $this->addSql('CREATE TABLE birds (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, garden_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_FC1659A239F3B087 FOREIGN KEY (garden_id) REFERENCES garden (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO birds (id, garden_id, name, description) SELECT id, garden_id, name, description FROM __temp__birds');
        $this->addSql('DROP TABLE __temp__birds');
        $this->addSql('CREATE INDEX IDX_FC1659A239F3B087 ON birds (garden_id)');
    }
}
