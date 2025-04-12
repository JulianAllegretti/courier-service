<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250412181928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create CodDane Table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cod_dane (id INT AUTO_INCREMENT NOT NULL, depto VARCHAR(180) NOT NULL, provincia VARCHAR(180) NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cod_dane');
    }
}
