<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728021926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a guide number table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE guide_number (
            id_guide_number INT NOT NULL AUTO_INCREMENT,
            initial_number VARCHAR(255) NOT NULL,
            end_number VARCHAR(255) NOT NULL,
            current_number VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id_guide_number)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE guide_number');
    }
}
