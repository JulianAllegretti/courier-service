<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250522000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add event_name and id_case to radicado; add nombre_archivo to documento';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE radicado ADD COLUMN event_name VARCHAR(100) NULL AFTER codigo_guia');
        $this->addSql('ALTER TABLE radicado ADD COLUMN id_case VARCHAR(100) NULL AFTER event_name');
        $this->addSql('ALTER TABLE documento ADD COLUMN nombre_archivo VARCHAR(255) NULL AFTER end_point_file_net');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE radicado DROP COLUMN event_name');
        $this->addSql('ALTER TABLE radicado DROP COLUMN id_case');
        $this->addSql('ALTER TABLE documento DROP COLUMN nombre_archivo');
    }
}
