<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251010214016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__garden AS SELECT id, member_id, description, size, name FROM garden');
        $this->addSql('DROP TABLE garden');
        $this->addSql('CREATE TABLE garden (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_3C0918EA7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO garden (id, member_id, description, size, name) SELECT id, member_id, description, size, name FROM __temp__garden');
        $this->addSql('DROP TABLE __temp__garden');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C0918EA7597D3FE ON garden (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__garden AS SELECT id, member_id, description, size, name FROM garden');
        $this->addSql('DROP TABLE garden');
        $this->addSql('CREATE TABLE garden (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_3C0918EA7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO garden (id, member_id, description, size, name) SELECT id, member_id, description, size, name FROM __temp__garden');
        $this->addSql('DROP TABLE __temp__garden');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C0918EA7597D3FE ON garden (member_id)');
    }
}
