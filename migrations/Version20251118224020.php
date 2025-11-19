<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118224020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__aviary AS SELECT id, member_id, description, published FROM aviary');
        $this->addSql('DROP TABLE aviary');
        $this->addSql('CREATE TABLE aviary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, published BOOLEAN NOT NULL, CONSTRAINT FK_3F13A3417597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO aviary (id, member_id, description, published) SELECT id, member_id, description, published FROM __temp__aviary');
        $this->addSql('DROP TABLE __temp__aviary');
        $this->addSql('CREATE INDEX IDX_3F13A3417597D3FE ON aviary (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__aviary AS SELECT id, member_id, description, published FROM aviary');
        $this->addSql('DROP TABLE aviary');
        $this->addSql('CREATE TABLE aviary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, published BOOLEAN NOT NULL, CONSTRAINT FK_3F13A3417597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO aviary (id, member_id, description, published) SELECT id, member_id, description, published FROM __temp__aviary');
        $this->addSql('DROP TABLE __temp__aviary');
        $this->addSql('CREATE INDEX IDX_3F13A3417597D3FE ON aviary (member_id)');
    }
}
