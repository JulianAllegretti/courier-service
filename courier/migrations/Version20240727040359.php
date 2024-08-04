<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727040359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a logs tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE log_insert_information (
            id_log_insert_information INT NOT NULL AUTO_INCREMENT,
            numero_radicado VARCHAR(50) NOT NULL,
            request TEXT NOT NULL,
            error TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_log_insert_information)
        )');

        $this->addSql('CREATE TABLE log_get_document (
            id_log_get_document INT NOT NULL AUTO_INCREMENT,
            numero_radicado VARCHAR(50) NOT NULL,
            id_documento VARCHAR(100) NOT NULL,
            request TEXT NOT NULL,
            error TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_log_get_document)
        )');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE log_insert_information');
        $this->addSql('DROP TABLE log_get_document');
    }
}
