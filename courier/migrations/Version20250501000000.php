<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add indexes to identificacion table and foreign key index on radicado table
 * This migration fixes performance issues with JOIN queries
 */
final class Version20250501000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add indexes to identificacion table and foreign key index on radicado table for better JOIN performance';
    }

    public function up(Schema $schema): void
    {
        // Índice en la foreign key de radicado hacia identificacion
        // Este es CRÍTICO para mejorar el rendimiento de los JOINs
        $this->addSql('CREATE INDEX idx_radicado_fk_identificacion ON radicado (fk_identificacion)');

        // Índices en identificacion para búsquedas y JOINs más rápidos
        $this->addSql('CREATE INDEX idx_identificacion_documento ON identificacion (documento)');
        $this->addSql('CREATE INDEX idx_identificacion_tipo_documento ON identificacion (tipo_documento)');

        // Índice compuesto para búsquedas por documento y tipo
        $this->addSql('CREATE INDEX idx_identificacion_documento_tipo ON identificacion (documento, tipo_documento)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX idx_radicado_fk_identificacion ON radicado');
        $this->addSql('DROP INDEX idx_identificacion_documento ON identificacion');
        $this->addSql('DROP INDEX idx_identificacion_tipo_documento ON identificacion');
        $this->addSql('DROP INDEX idx_identificacion_documento_tipo ON identificacion');
    }
}
