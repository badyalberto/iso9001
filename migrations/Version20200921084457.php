<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921084457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E3801D3EB');
        $this->addSql('DROP INDEX IDX_B6F7494E3801D3EB ON question');
        $this->addSql('ALTER TABLE question DROP blockquestions_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question ADD blockquestions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E3801D3EB FOREIGN KEY (blockquestions_id) REFERENCES block (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E3801D3EB ON question (blockquestions_id)');
    }
}
