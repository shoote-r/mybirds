<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118223501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aviary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, published BOOLEAN NOT NULL, CONSTRAINT FK_3F13A3417597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3F13A3417597D3FE ON aviary (member_id)');
        $this->addSql('CREATE TABLE aviary_birds (aviary_id INTEGER NOT NULL, birds_id INTEGER NOT NULL, PRIMARY KEY(aviary_id, birds_id), CONSTRAINT FK_E836D36D168D8C0C FOREIGN KEY (aviary_id) REFERENCES aviary (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E836D36D23101F8E FOREIGN KEY (birds_id) REFERENCES birds (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E836D36D168D8C0C ON aviary_birds (aviary_id)');
        $this->addSql('CREATE INDEX IDX_E836D36D23101F8E ON aviary_birds (birds_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aviary');
        $this->addSql('DROP TABLE aviary_birds');
    }
}
