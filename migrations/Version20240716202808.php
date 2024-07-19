<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716202808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces CHANGE autres_equipements autres_equipements LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE is_archived is_archived TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces CHANGE autres_equipements autres_equipements VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE is_archived is_archived TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE messages DROP is_archived');
    }
}
