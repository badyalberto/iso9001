<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921074611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE block CHANGE position position VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD si TINYINT(1) NOT NULL, ADD no TINYINT(1) NOT NULL, ADD noimplementada TINYINT(1) NOT NULL, ADD notesteado TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE block CHANGE position position INT NOT NULL');
        $this->addSql('ALTER TABLE question DROP si, DROP no, DROP noimplementada, DROP notesteado');
    }
}
